<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/entity/Seat.php";

class SeatRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $db = $this->getdb();
        $db->exec("SET SQL_BIG_SELECTS=1");

        $query = $db->prepare("SELECT s.*
        FROM Seat s, Room r, Showing sh, VenueShowing vs
        WHERE s.roomId = r.roomId
        AND sh.roomId = r.roomId
        AND vs.showingId = sh.showingId
        AND sh.showingId = :showingId
        AND vs.venueId = :venueId");
        try {
            $query->execute(array(":showingId" => $showingId, ":venueId" => $selectedVenueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No seats found for this showing");
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch seats for showing");
        }
    }

    public function getSeatById(int $seatId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Seat WHERE seatId = :seatId");
        try {
            $query->execute(array(":seatId" => $seatId));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No seat found. ");
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch seat with ID.");
        }
    }
}