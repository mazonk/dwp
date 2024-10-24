<?php
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Actor.php";
include_once "src/model/entity/Director.php";
class MovieRepository {
    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }
    public function getAllMovies(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Movie");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No movies found");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch movies: ". $e->getMessage());
        }

        return $result;
    }

    public function getActorsByMovieId(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT a.* FROM Actor as a JOIN MovieActor as ma ON a.actorId = ma.actorId WHERE ma.movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId)  );
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return []; // No actors found for this movie
            }
        }
        catch (PDOException $e) {
            throw new Exception("Unable to fetch actors" . $e->getMessage());
        }

        return $result;
    }

    public function getDirectorsByMovieId(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT d.* FROM Director as d JOIN MovieDirector as md ON d.directorId = md.directorId WHERE md.movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return []; // No directors found for this movie
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch directors: ". $e->getMessage());
        }

        return $result;
    }

    public function getMovieById(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Movie as m WHERE m.movieId = :movieId");
        try{
            $query->execute(array(":movieId" => $movieId));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No movie found with id: ". $movieId);
            }
        }
        catch (PDOException $e) {
            echo "Couldn't fetch movie: " . $e->getMessage();
        }
        
        return $result;
    }
}