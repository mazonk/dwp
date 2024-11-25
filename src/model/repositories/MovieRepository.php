<?php
class MovieRepository {
    private function getdb(): PDO {
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
                throw new Exception("No movies found!");
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch movies!");
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
            throw new PDOException("Unable to fetch actors!");
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
            throw new PDOException("Unable to fetch directors!");
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
                throw new Exception("No movie found!");
            }
        }
        catch (PDOException $e) {
            throw new PDOException("Unable to fetch movie!");
        }
        
        return $result;
    }

    public function addMovie(array $movieData): void {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO Movie (name, year, rating, imageURL) VALUES (:name, :year, :rating, :imageURL)");
        try {
            $query->execute(array(":name" => $movieData['name'], ":year" => $movie['year'], ":rating" => $movie['rating'], ":imageURL" => $movie['imageURL']));
        } catch (PDOException $e) {
            throw new PDOException("Unable to add movie!");
        }
    }

    public function editMovie(array $movieData): void {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE Movie SET name = :name, year = :year, rating = :rating, imageURL = :imageURL WHERE movieId = :movieId");
        try {
            $query->execute(array(":name" => $movieData['name'], ":year" => $movie['year'], ":rating" => $movie['rating'], ":imageURL" => $movie['imageURL'], ":movieId" => $movie['movieId']));
        } catch (PDOException $e) {
            throw new PDOException("Unable to edit movie!");
        }
    }

    public function deleteMovie(int $movieId): void {
        $db = $this->getdb();
        $query = $db->prepare("DELETE FROM Movie WHERE movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId));
        } catch (PDOException $e) {
            throw new PDOException("Unable to delete movie!");
        }
    }
}