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
        $retArray =  [];
        foreach ($result as $row) {
            $actors = $this->getActorsByMovieId($row['movieId']);
            $directors = $this->getDirectorsByMovieId($row['movieId']);
            $retArray[] = new Movie($row['movieId'], $row['title'], $row['description'], $row['duration'], $row['language'], $row['releaseDate'], $row['posterURL'], $row['promoURL'],$row['rating'],$row['trailerURL'], $actors, $directors);
        }
        return $retArray;
    }
    private function getActorsByMovieId(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT a.* FROM Actor as a JOIN MovieActor as ma ON a.actorId = ma.actorId WHERE ma.movieId = ?");
        $query->execute([$movieId]);
        $actors = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $actors[] = new Actor($row['actorId'], $row['firstName'], $row['lastName'], $row['character']);
        }
        return $actors;
    }

    private function getDirectorsByMovieId(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT d.* FROM Director as d JOIN MovieDirector as md ON d.directorId = md.directorId WHERE md.movieId = ?");
        $query->execute([$movieId]);
        $directors = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $directors[] = new Director($row['directorId'], $row['firstName'], $row['lastName']);
        }
        return $directors;
    }

    public function getMovieById(int $movieId): Movie {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Movie as m WHERE m.movieId = ?");
        try{
        $query->execute([$movieId]);
        $result = $query->fetch(PDO::FETCH_ASSOC); 
        }
        catch (PDOException $e) {
            echo "Couldn't fetch movie: " . $e->getMessage();
        }
        if (empty($result)) {
            return null;
        } 
        $actors = $this->getActorsByMovieId($movieId);
        $directors = $this->getDirectorsByMovieId($movieId);
        return new Movie($result["movieId"], $result["title"], $result["description"], $result["duration"], $result["language"], $result["releaseDate"], $result["posterURL"], $result["promoURL"], $result["rating"], $result["trailerURL"], $actors, $directors);
    }
}