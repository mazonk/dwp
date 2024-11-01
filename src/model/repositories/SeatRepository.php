<?php
include_once "src/model/entity/Seat.php";

class SeatRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Seat WHERE showingId = :showingId AND venueId = :venueId");
        try {
            $query->execute(array(":showingId" => $showingId, ":venueId" => $selectedVenueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No seats found for this showing");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch seats for showing");
        }

        return $result;
    }
}