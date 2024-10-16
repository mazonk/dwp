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
            $query->execute(array(":venueId" => $venueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);   
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }
}
