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
        $query = $db->prepare("SELECT s.* 
            FROM Seat s
            JOIN Room r ON s.roomId = r.roomId
            JOIN VenueShowing vs ON r.venueId = vs.venueId
            JOIN Showing sh ON vs.showingId = sh.showingId
            LEFT JOIN Ticket t ON s.seatId = t.seatId AND t.showingId = sh.showingId
            WHERE sh.showingId = :showingId AND vs.venueId = :venueId AND t.ticketId IS NULL
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
}