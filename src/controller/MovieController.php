<?php
include_once "src/model/services/MovieService.php";

class MovieController {
    private MovieService $movieService;

    public function __construct() {
        $this->movieService = new MovieService();
    }

    public function getAllMovies(): array {
        $movies = $this->movieService->getAllMovies();

        // If the service returns an error, pass it to the frontend
        if (isset($movies['error']) && $movies['error']) {
            return ['errorMessage' => $movies['message']];
        }
        
        return $movies;
    }

    public function getAllActiveMovies(): array {
        $movies = $this->movieService->getAllActiveMovies();

        // If the service returns an error, pass it to the frontend
        if (isset($movies['error']) && $movies['error']) {
            return ['errorMessage' => $movies['message']];
        }
        
        return $movies;
    }

    public function getMoviesWithShowings(): array {
        $movies = $this->movieService->getMoviesWithShowings();

        // If the service returns an error, pass it to the frontend
        if (isset($movies['error']) && $movies['error']) {
            return ['errorMessage' => $movies['message']];
        }    
        return $movies;
    }

    public function getMovieById(int $movieId): array|Movie {
        $movie = $this->movieService->getMovieById(htmlspecialchars($movieId));
        
        // If the service returns an error, pass it to the frontend
        if (is_array($movie) && isset($movie['error']) && $movie['error']) {
            return ['errorMessage' => $movie['message']];
        }
        
        return $movie;
    }

    public function addMovie(array $movieData): array {
        $errors = $this->movieService->addMovie($movieData);
        if(count($errors) == 0) {
            // Check if there are any errors from adding the news
            if (isset($errors['error']) && $errors['error']) {
                return ['errorMessage' => $errors['message']];
            }
            return ['success' => true];
        } else {
            return $errors;
        }
    }

    public function editMovie(array $movieData): array {
        $errors = $this->movieService->editMovie($movieData);
        if(count($errors) == 0) {
            // Check if there are any errors from adding the news
            if (isset($errors['error']) && $errors['error']) {
                return ['errorMessage' => $errors['message']];
            }
            return ['success' => true];
        } else {
            return $errors;
        }
    }

    public function deleteMovie(int $movieId): array {
        $result = $this->movieService->deleteMovie(htmlspecialchars($movieId));
        if (isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        }
        return ['success' => true];
    }

    public function archiveMovie(int $movieId): array {
        $result = $this->movieService->archiveMovie(htmlspecialchars($movieId));
        if (isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        }
        return ['success' => true];
    }
}
