<?php
include_once "src/model/entity/Seat.php";

class SeatRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT s.*
        FROM Seat s, Room r, Showing sh, venueshowing vs
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
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch seats for showing");
        }
        return $result;
    }

public function getAvailableSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT 
    ( 
        SELECT COUNT(s.seatId)
        FROM Seat s
        JOIN Room r ON s.roomId = r.roomId
        JOIN Showing sh ON sh.roomId = r.roomId
        JOIN VenueShowing vs ON vs.showingId = sh.showingId
        WHERE sh.showingId =  :showingId
        AND vs.venueId = :venueId
    ) 
    - 
    (
        SELECT COUNT(*)
        FROM Ticket t
        WHERE t.showingId =  :showingId
    ) AS available_seats;
        ");
        try {
            $query->execute(array(":showingId" => $showingId, ":venueId" => $selectedVenueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No available seats found for this showing");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch available seats for showing: " . $e->getMessage());
        }
        return $result;
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
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch seat with ID.");
        }
        return $result;
    }

    public function selectSeat(int $seatId): void { //TRANSACTION
        $db = $this->getdb();
        $query = $db->prepare("UPDATE Seat SET selected = 1 WHERE seatId = :seatId");
        try {
            $query->execute(array(":seatId" => $seatId));
        } catch (PDOException $e) {
            throw new Exception("Unable to select seat. ");
        }
    }
}