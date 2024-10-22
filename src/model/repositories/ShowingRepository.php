<?php
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Venue.php";

class ShowingRepository {
    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getShowingById($showingId) {
        $db = $this->getdb();
        try {
            $query = $db->prepare("SELECT * FROM Showing as s WHERE s.showingId = ?");
            $query->execute([$showingId]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return null;
            }
            return $result;
        } catch (PDOException $e) {
            return null;
    }
}

    public function getShowingIdsForVenue($venueId): array {
        $db = $this->getdb();
        
        try {
            $query = $db->prepare("SELECT * FROM VenueShowing as vs WHERE vs.venueId = :venueId");
            $query->execute(array(":venueId" => htmlspecialchars($venueId)));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);   
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getShowingForMovie($movieId, $selectedVenueId): array {
        $db = $this->getdb();

        try {
            $query = $db->prepare("SELECT * FROM Showing as s JOIN VenueShowing as vs ON s.showingId = vs.showingId WHERE vs.venueId = :venueId 
            AND s.movieId = :movieId ORDER BY s.showingDate, s.showingTime ASC");
            $query->execute(array(":movieId" => $movieId, ":venueId" => htmlspecialchars($selectedVenueId)));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Gets the movies playing today for the given venue.
     *
     * @param int $venueId The ID of the venue to get the movies for.
     *
     * @return array An array of movie IDs that are playing today at the given venue.
     */
    public function getMoviesPlayingToday($venueId) {
        $db = $this->getdb();
        $today = date('Y-m-d');
        $showingIds = $this->getShowingIdsForVenue($venueId);
        $showingIdsList = [];
        foreach ($showingIds as $showing) {
            array_push($showingIdsList, $showing['showingId']);
        }
    
        if (empty($showingIdsList)) {
            return []; // If there are no showings, return an empty result.
        }
        try {
            // Join array elements with a separator string, it'll look sg like this: (1,2,3,4)
            $placeholders = implode(',', array_fill(0, count($showingIdsList), '?'));
            $query = $db->prepare(
            "SELECT DISTINCT s.movieId 
            FROM Showing as s 
            WHERE s.showingId IN ($placeholders) 
            AND s.showingDate = ?");
            
            // Merge the showing IDs and today's date
            $query->execute(array_merge($showingIdsList, [$today]));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }
}