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

    public function isArchived(int $movieId): bool {
        $activeMovies = $this->getAllActiveMovies();
    
        // Check if the result contains an error message
        if (isset($activeMovies['errorMessage'])) {
            // Handle the error case appropriately here
            return false; // Default value, or consider throwing an exception
        }
    
        // Extract the IDs of active movies
        $activeMovieIds = array_map(fn($movie) => $movie->getMovieId(), $activeMovies);
    
        // Return true if the movie ID is NOT in the list of active movie IDs
        return !in_array($movieId, $activeMovieIds);
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

    public function restoreMovie(int $movieId): array {
        $result = $this->movieService->restoreMovie(htmlspecialchars($movieId));
        if (isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        }
        return ['success' => true];
    }

    public function getAllGenres(): array {
        $genres = $this->movieService->getAllGenres();
        if (isset($genres['error']) && $genres['error']) {
            return ['errorMessage' => $genres['message']];
        }
        return $genres;
    }

    public function getAllGenresByMovieId(int $movieId): array {
        $genres = $this->movieService->getAllGenresByMovieId(htmlspecialchars($movieId));
        if (isset($genres['error']) && $genres['error']) {
            return ['errorMessage' => $genres['message']];
        }
        return $genres;
    }
}
