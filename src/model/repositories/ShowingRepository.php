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

    public function getShowingById($showingId): Showing {
        $db = $this->getdb();
        try {
            $query = $db->prepare("SELECT * FROM Showing WHERE showingId = ?");
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
            $query = $db->prepare("SELECT * FROM VenueShowing WHERE venueId = ?");
            $query->execute([$venueId]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);            
            $retArray = [];
            foreach ($result as $row) {
                $retArray[] = new Showing(
                    $row['showingId'], 
                    $row['venueId']
                );
            }
            return $retArray;
        } catch (PDOException $e) {
            return [];
        }
    }
}
