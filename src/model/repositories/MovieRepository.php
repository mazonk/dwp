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
        $query = $db->prepare("INSERT INTO Movie (title, description, duration, language, releaseDate, posterURL, promoURL, trailerURL, rating) VALUES
 (:title, :year, :rating, :imageURL)");
        try {
            $query->execute(array(":title" => $movieData['title'],":description"=> $movieData['description'], ":duration" => $movieData['duration'], ":language" => $movieData['language'], ":releaseDate" => $movieData['releaseDate'], ":posterURL" => $movieData['posterURL'], ":promoURL" => $movieData['promoURL'], ":trailerURL" => $movieData['trailerURL'], ":rating" => $movieData['rating']));
        } catch (PDOException $e) {
            throw new PDOException("Unable to add movie!");
        }
    }

    public function editMovie(array $movieData): void {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE Movie SET title = :title, description = :description, duration = :duration, language = :language, releaseDate = :releaseDate, posterURL = :posterURL, promoURL = :promoURL, trailerURL = :trailerURL, rating = :rating WHERE movieId = :movieId");
        try {
            $query->execute(array(":title" => $movieData['title'],":description"=> $movieData['description'], ":duration" => $movieData['duration'], ":language" => $movieData['language'], ":releaseDate" => $movieData['releaseDate'], ":posterURL" => $movieData['posterURL'], ":promoURL" => $movieData['promoURL'], ":trailerURL" => $movieData['trailerURL'], ":rating" => $movieData['rating']));
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