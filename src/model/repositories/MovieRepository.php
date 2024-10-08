<?php
include "src/model/entity/Movie.php";
class MovieRepository {
    private function getdb() {
        include_once "src/model/database/dbcon/dbcon.php";
        return $db;
    }
    public function getAllMovies(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Movie");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $retArray =  [];
        foreach ($result as $row) {
            $retArray[] = new Movie($row['movieId'], $row['title'], $row['description'], $row['duration'], $row['language'], $row['releaseDate'], $row['posterURL'], $row['promoURL'],$row['rating'],$row['trailerURL']);
        }
        return $retArray;
    }
}