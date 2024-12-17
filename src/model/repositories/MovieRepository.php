<?php
class MovieRepository {
    private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
  }
    public function getAllMovies(): array {
        $query = $this->db->prepare("SELECT * FROM Movie");
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

    public function getAllActiveMovies(): array {
        $query = $this->db->prepare("SELECT * FROM Movie WHERE archived = 0");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No active movies found!");
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch active movies!");
        }

        return $result;
    }

    public function getMoviesWithShowings(): array {
        $query = $this->db->prepare("SELECT * FROM MoviesWithShowings");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No movies with showings found!");
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch movies with showings!");
        }

        return $result;
    }

    public function getActorsByMovieId(int $movieId): array {
        $query = $this->db->prepare("SELECT a.* FROM Actor as a JOIN MovieActor as ma ON a.actorId = ma.actorId WHERE ma.movieId = :movieId");
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
        $query = $this->db->prepare("SELECT d.* FROM Director as d JOIN MovieDirector as md ON d.directorId = md.directorId WHERE md.movieId = :movieId");
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
        $query =$this->db->prepare("SELECT * FROM Movie as m WHERE m.movieId = :movieId");
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

    public function addMovie(array $movieData): int {
        $query = $this->db->prepare("INSERT INTO Movie (title, description, duration, language, releaseDate, posterURL, promoURL, trailerURL, rating) VALUES
 (:title, :description, :duration, :language, :releaseDate, :posterUrl, :promoUrl, :trailerUrl, :rating)");
        try {
            $query->execute(array(":title" => $movieData['title'],":description"=> $movieData['description'], ":duration" => $movieData['duration'], ":language" => $movieData['language'], ":releaseDate" => $movieData['releaseDate'], ":posterUrl" => $movieData['posterURL'], ":promoUrl" => $movieData['promoURL'], ":trailerUrl" => $movieData['trailerURL'], ":rating" => $movieData['rating']));
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Unable to add movie!");
        }
    }

    public function editMovie(array $movieData): int {
        $query = $this->db->prepare("UPDATE Movie SET title = :title, description = :description, duration = :duration, language = :language, releaseDate = :releaseDate, posterURL = :posterURL, promoURL = :promoURL, trailerURL = :trailerURL, rating = :rating WHERE movieId = :movieId");
        try {
            $query->execute(array(":title" => $movieData['title'],":description"=> $movieData['description'], ":duration" => $movieData['duration'], ":language" => $movieData['language'], ":releaseDate" => $movieData['releaseDate'], ":posterURL" => $movieData['posterURL'], ":promoURL" => $movieData['promoURL'], ":trailerURL" => $movieData['trailerURL'], ":rating" => $movieData['rating'] , ":movieId" => $movieData['movieId']));
            return intval($movieData['movieId']);
        } catch (PDOException $e) {
            throw new PDOException("Unable to edit movie!");
        }
    }

    public function archiveMovie(int $movieId): void {
        $query = $this->db->prepare("UPDATE Movie SET archived = 1 WHERE movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId));
        } catch (PDOException $e) {
            throw new PDOException("Unable to archive movie!");
        }
    }

    public function restoreMovie(int $movieId): void {
        $query = $this->db->prepare("UPDATE Movie SET archived = 0 WHERE movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId));
        } catch (PDOException $e) {
            throw new PDOException("Unable to restore movie!");
        }
    }
}

