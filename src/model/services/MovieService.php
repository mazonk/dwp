<?php
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Actor.php";
include_once "src/model/entity/Director.php";
include_once "src/model/repositories/MovieRepository.php";

class MovieService {

    private MovieRepository $movieRepository;
    public function __construct() {
        $this->movieRepository = new MovieRepository();
    }

    public function getAllMovies(): array {
        $rawMovies = $this->movieRepository->getAllMovies();
        $movies = [];
        foreach ($rawMovies as $row) {
            $movies[] = $this->createMovieMap($row);
        }
        return $movies;
    }

    public function getMovieById(int $movieId): ?Movie {
        $result = $this->movieRepository->getMovieById($movieId);
        if ($result === null) {
            return null;
        }
        return $this->createMovieMap($result);
    }

    public function getActorsByMovieId(int $movieId) {
        $result = $this->movieRepository->getActorsByMovieId($movieId);
        $actors = [];
        foreach ($result as $row) {
            $actors[] = new Actor($row['actorId'], $row['firstName'], $row['lastName'], $row['character']);
        }
        return $actors;
    }

    public function getDirectorsByMovieId(int $movieId) {
        $result = $this->movieRepository->getDirectorsByMovieId($movieId);
        $directors = [];
        foreach ($result as $row) {
            $directors[] = new Director($row['directorId'], $row['firstName'], $row['lastName']);
        }
        return $directors;
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
}
