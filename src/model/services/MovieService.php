<?php
include_once "src/model/entity/Movie.php";
include_once "src/model/repositories/MovieRepository.php";

class MovieService {

    private MovieRepository $movieRepository;
    public function __construct() {
        $this->movieRepository = new MovieRepository();
    }

    public function getAllMovies(): array {
        return $this->movieRepository->getAllMovies();
    }

    public function getMovieById(int $movieId): Movie {
        return $this->movieRepository->getMovieById($movieId);
    }
}
