<?php
include_once "src/model/repositories/MovieRepository.php";

class MovieController {
    private MovieRepository $movieRepository;

    public function __construct() {
        $this->movieRepository = new MovieRepository();
    }

    public function getAllMovies(): array {
        return $this->movieRepository->getAllMovies();
    }
}
?>
