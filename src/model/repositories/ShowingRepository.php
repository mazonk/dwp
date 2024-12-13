<?php
include_once "src/model/entity/Showing.php";

class ShowingRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getShowingById(int $showingId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Showing as s WHERE s.showingId = :showingId");
        try {
            $query->execute(array(":showingId" => $showingId));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showing found!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showing!");
        }

        return $result;
    }

    public function getShowingsForMovie(int $movieId, int $selectedVenueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Showing as s JOIN VenueShowing as vs ON s.showingId = vs.showingId WHERE vs.venueId = :venueId 
        AND s.movieId = :movieId ORDER BY s.showingDate, s.showingTime ASC");
        try {
            $query->execute(array(":movieId" => $movieId, ":venueId" => $selectedVenueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for this movie!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }

    public function getShowingsForMovieAdmin(int $movieId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM ShowingsWithDetails as swd WHERE swd.movieId = :movieId ORDER BY swd.showingDate, swd.showingTime ASC");
        try {
            $query->execute(array(":movieId" => $movieId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for this movie!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }

    /**
     * Gets the movies playing today for the given venue.
     *
     * @param int $venueId The ID of the venue to get the movies for.
     *
     * @return array An array of movie IDs that are playing today at the given venue.
     */
    public function getMoviesPlayingToday(int $venueId): array {
        $db = $this->getdb();
        $today = date('Y-m-d');
        try {
            $showingIds = $this->getShowingIdsForVenue($venueId);
            $showingIdsList = [];
            foreach ($showingIds as $showing) {
                array_push($showingIdsList, $showing['showingId']);
            }
    
            if (empty($showingIdsList)) {
                throw new Exception("No showings found for this Venue!");
            }
        } catch (PDOException $e) {
            throw $e;
        }
        try {
            // Join array elements with a separator string, it'll look sg like this: (1,2,3,4)
            $placeholders = implode(',', array_fill(0, count($showingIdsList), '?'));
            $query = $db->prepare(
                "SELECT DISTINCT s.movieId 
            FROM Showing as s 
            WHERE s.showingId IN ($placeholders) 
            AND s.showingDate = ?"
            );

            // Merge the showing IDs and today's date
            $query->execute(array_merge($showingIdsList, [$today]));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for today!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch movies playing today!");
        }

        return $result;
    }

    private function getShowingIdsForVenue(int $venueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM VenueShowing as vs WHERE vs.venueId = :venueId");
        try {
            $query->execute(array(":venueId" => $venueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }
}
