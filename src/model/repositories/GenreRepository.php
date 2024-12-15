<?php

class GenreRepository
{
    private function getdb(): PDO
    {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllGenresByMovieId(int $movieId): array
    {
        $db = $this->getdb();
        $query = $db->prepare("SELECT g.* FROM genre as g JOIN movieGenre as mg ON g.genreId = mg.genreId WHERE mg.movieId = :movieId");
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

    public function getAllGenres(): array
    {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM genre");
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

    public function addGenresToMovie(int $movieId, array $genreIds): void {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO movieGenre (movieId, genreId) VALUES (:movieId, :genreId)");
        try {
            foreach ($genreIds as $genreId) {
                $query->execute(array(":movieId" => $movieId, ":genreId" => $genreId));
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to add genres to movie!");
        }
    }
}
