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
}
