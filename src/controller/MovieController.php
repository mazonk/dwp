<?php
include_once "src/model/services/MovieService.php";

class MovieController {
    private MovieService $movieService;

    public function __construct() {
        $this->movieService = new MovieService();
    }

    public function getAllMovies(): array {
        return $this->movieService->getAllMovies();
    }

    public function getMovieById(int $movieId): Movie {
        return $this->movieService->getMovieById($movieId);
    }
}
?>
