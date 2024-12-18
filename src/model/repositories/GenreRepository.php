<?php

class GenreRepository
{

    public function __construct() {
    }

    private function getdb(): PDO
    {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllGenresByMovieId(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT g.* FROM Genre as g JOIN MovieGenre as mg ON g.genreId = mg.genreId WHERE mg.movieId = :movieId");
        try {
            $query->execute(array(":movieId" => $movieId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return []; // No genres found for this movie
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch genres!");
        }
        return $result;
    }

    public function removeGenresForMovieId(int $movieId): bool {
        $db = $this->getdb();
        $query = $db->prepare("DELETE FROM MovieGenre WHERE movieId = :movieId");
        try {
            $wasRemoved = $query->execute(array(":movieId" => $movieId));
            return $wasRemoved;
        } catch (PDOException $e) {
            throw new PDOException("Unable to remove genres!");
        }
    }

    public function getAllGenres(): array
    {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Genre");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No genres found!");
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch genres!");
        }
        return $result;
    }

    public function addGenresToMovie(int $movieId, array $genreIds): bool {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO MovieGenre (movieId, genreId) VALUES (:movieId, :genreId)");
        try {
            foreach ($genreIds as $genreId) {
                $query->execute(array(":movieId" => $movieId, ":genreId" => $genreId));
            }                 
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Unable to add genres to movie!");
        } 
    }
}
