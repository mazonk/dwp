<?php
include_once "src/model/repositories/GenreRepository.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Genre.php";
class GenreService {
    private GenreRepository $genreRepository;
    public function __construct() {
        $this->genreRepository = new GenreRepository();
    }

    public function getAllGenres(): array {
        try {
            $result = $this->genreRepository->getAllGenres();
            $genres = [];
            foreach ($result as $genre) {
                $genres[] = new Genre($genre['genreId'], $genre['name']);
            }
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $genres;
    }

    public function getAllGenresByMovieId(int $movieId): array {
        try {
            $result = $this->genreRepository->getAllGenresByMovieId($movieId);
            $genres = [];
            foreach ($result as $genre) {
                $genres[] = new Genre($genre['genreId'], $genre['name']);
            }
        } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
        return $genres;
    }

    public function addGenresToMovie(int $movieId, array $genreIds): array {
        $errors = [];
        if (count($errors) == 0) {
            try {
            $this->genreRepository->addGenresToMovie($movieId, $genreIds);
            return ['success' => true];
            } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
            }
        } else {
         return $errors;    
        }
    }
}