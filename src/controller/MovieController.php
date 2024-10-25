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

    public function getMovieById(int $movieId): array|Movie {
        $movie = $this->movieService->getMovieById($movieId);
        
        // If the service returns an error, pass it to the frontend
        if (is_array($movie) && isset($movie['error']) && $movie['error']) {
            return ['errorMessage' => $movie['message']];
        }
        
        return $movie;
    }
}
