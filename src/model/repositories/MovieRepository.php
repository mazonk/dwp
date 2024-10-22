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
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getActorsByMovieId(int $movieId) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT a.* FROM Actor as a JOIN MovieActor as ma ON a.actorId = ma.actorId WHERE ma.movieId = ?");
        try {
            $query->execute([$movieId]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            } else {
                return $result;
            }
        }
        catch (PDOException $e) {
            echo "Couldn't fetch actors: " . $e->getMessage();
        }
    }

    public function getDirectorsByMovieId(int $movieId) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT d.* FROM Director as d JOIN MovieDirector as md ON d.directorId = md.directorId WHERE md.movieId = ?");
        try {
            $query->execute([$movieId]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            } else {
                return $result;
            }
        } catch (PDOException $e) {
            echo "Couldn't fetch directors: ". $e->getMessage();
        }
    }

    public function getMovieById(int $movieId) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Movie as m WHERE m.movieId = ?");
        try{
            $query->execute([$movieId]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $e) {
            echo "Couldn't fetch movie: " . $e->getMessage();
        }
    }
}