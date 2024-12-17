<?php
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Actor.php";
include_once "src/model/entity/Director.php";
include_once "src/model/repositories/MovieRepository.php";
include_once "src/model/services/GenreService.php";

class MovieService {
    private MovieRepository $movieRepository;
    private GenreService $genreService;
    private PDO $db;
     
    public function __construct() {
        $this->db = $this->getdb();
        $this->movieRepository = new MovieRepository($this->db);
        $this->genreService = new GenreService();
    }

    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
      }

    public function getAllMovies(): array {
        try {
            $result = $this->movieRepository->getAllMovies();
            $movies = [];
            foreach ($result as $row) {
                $movies[] = $this->createMovieMap($row);
            }
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $movies;
    }

    public function getAllActiveMovies(): array {
        try {
            $result = $this->movieRepository->getAllActiveMovies();
            $movies = [];
            foreach ($result as $row) {
                $movies[] = $this->createMovieMap($row);
            }
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $movies;
    }

    public function getMoviesWithShowings(): array {
        try {
            $result = $this->movieRepository->getMoviesWithShowings();
            $movies = [];
            foreach ($result as $row) {
                $movies[] = [
                    'movieId' => $row['movieId'],
                    'title' => $row['title'],
                    'numberOfShowings' => $row['numberOfShowings']
                ];
            }
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $movies;
    }

    public function getMovieById(int $movieId): array|Movie {
        try {
            $result = $this->movieRepository->getMovieById($movieId);
            return $this->createMovieMap($result);
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getActorsByMovieId(int $movieId): array {
        try {
            $result = $this->movieRepository->getActorsByMovieId($movieId);
            $actors = [];
            foreach ($result as $row) {
                $actors[] = new Actor($row['actorId'], $row['firstName'], $row['lastName'], $row['character']);
            }
            return $actors;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getDirectorsByMovieId(int $movieId): array {
        try {
            $result = $this->movieRepository->getDirectorsByMovieId($movieId);
            $directors = [];
            foreach ($result as $row) {
                $directors[] = new Director($row['directorId'], $row['firstName'], $row['lastName']);
            }
            return $directors;
        } catch (Exception $e) {
            return [];
        }
    }

    public function createMovieMap($row): Movie {
        $actors = $this->getActorsByMovieId($row['movieId']);
        $directors = $this->getDirectorsByMovieId($row['movieId']);
        return new Movie(
            $row['movieId'],
            $row['title'],
            $row['description'],
            $row['duration'],
            $row['language'],
            $row['releaseDate'],
            $row['posterURL'],
            $row['promoURL'],
            $row['rating'],
            $row['trailerURL'],
            $actors,
            $directors
        );
    }

    public function addMovie(array $movieData): array {
        $errors = [];
        $this->validateFormInputs($movieData, $errors);
        if (count($errors) == 0) {
            try {
                $this->db->beginTransaction();
                $result = $this->movieRepository->addMovie($movieData);
                $resultResult = $this->genreService->addGenresToMovie($result, $movieData['selectedGenres']);
                $this->db->commit();
                return ['success' => true];
            } catch (Exception $e) {
                $this->db->rollBack();
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } else {
            return $errors;
        }
    }

    public function editMovie(array $movieData): array {
        $errors = [];
        $this->validateFormInputs($movieData, $errors);
        if (count($errors) == 0) {
            try {
                $this->db->beginTransaction();
                $result = $this->movieRepository->editMovie($movieData);
                $resultResult = $this->genreService->addGenresToMovie($result, $movieData['selectedGenres']);
                if (!$resultResult['success']) {
                    $this->db->rollBack();
                    return ['error' => true, 'message' => 'Couldnt add genres to movie'];
                }
                $this->db->commit();
                return ['success' => true];
            } catch (Exception $e) {
                $this->db->rollBack();
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } else {
            return $errors;
        }
    }

    public function archiveMovie(int $movieId): array {
        try {
            $this->movieRepository->archiveMovie($movieId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function restoreMovie(int $movieId): array {
        try {
            $this->movieRepository->restoreMovie($movieId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    private function validateFormInputs(array $movieData, array &$errors): void {
    $regex = "/^[a-zA-Z0-9áéíóöúüűæøåÆØÅ\s\-\.,;:\'\"’!?]+$/u";
    
        // Perform checks
    if (empty($movieData['title']) || 
        empty($movieData['releaseDate']) || 
        empty($movieData['duration']) || 
        empty($movieData['language']) || 
        empty($movieData['description']) || 
        empty($movieData['rating'])) {
        $errors['general'] = "All fields are required.";
    }

    // Title validation
    if (!preg_match($regex, $movieData['title'])) {
        $errors['title'] = "Title must only contain letters, numbers, and basic punctuation.";
    }
    if (strlen($movieData['title']) < 2) {
        $errors['title'] = "Title must be at least 2 characters long.";
    }
    if (strlen($movieData['title']) > 255) {
        $errors['title'] = "Title can't be longer than 255 characters.";
    }

    // Release Date validation
    if (!strtotime($movieData['releaseDate'])) {
        $errors['releaseDate'] = "Release date must be a valid date.";
    }

    // Duration validation
    if (!is_numeric($movieData['duration']) || intval($movieData['duration']) <= 0) {
        $errors['duration'] = "Duration must be a positive number.";
    }

    // Language validation
    if (!preg_match($regex, $movieData['language'])) {
        $errors['language'] = "Language must only contain letters, numbers, and basic punctuation.";
    }
    if (strlen($movieData['language']) < 2) {
        $errors['language'] = "Language must be at least 2 characters long.";
    }
    if (strlen($movieData['language']) > 50) {
        $errors['language'] = "Language can't be longer than 50 characters.";
    }

    // Description validation
    if (!preg_match($regex, $movieData['description'])) {
        $errors['description'] = "Description must only contain letters, numbers, and basic punctuation.";
    }
    if (strlen($movieData['description']) < 25) {
        $errors['description'] = "Description must be at least 25 characters long.";
    }
    if (strlen($movieData['description']) > 1000) {
        $errors['description'] = "Description can't be longer than 1000 characters.";
    }

    // Rating validation
    if (!is_numeric($movieData['rating']) || 
        floatval($movieData['rating']) < 0 || 
        floatval($movieData['rating']) > 10) {
        $errors['rating'] = "Rating must be a number between 0 and 10.";
    }
    }
}
