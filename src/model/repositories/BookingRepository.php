<?php 
include_once "src/model/database/dbcon/DatabaseConnection.php";

class BookingRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }
    public function bookSeat(int $seatId, int $showingId, int $userId): bool {
        $db = $this->getdb();
        $stmt = $db->prepare("SELECT * FROM Ticket WHERE seatId = :seatId AND showingId = :showingId");
        $stmt->execute(['seatId' => $seatId, 'showingId' => $showingId]);
        if ($stmt->rowCount() > 0) {
            return false; // Seat is already booked
        }

        // Book the seat
        $stmt = $db->prepare("INSERT INTO Ticket (seatId, showingId, userId) VALUES (:seatId, :showingId, :userId)");
        return $stmt->execute(['seatId' => $seatId, 'showingId' => $showingId, 'userId' => $userId]);
    }
    public function getBookingById(int $bookingId): array {
        $db = $this->getdb();
        $stmt = $db->prepare("SELECT * FROM Booking WHERE bookingId = :bookingId");
        $stmt->execute(['bookingId' => $bookingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllSeatsForBooking(int $bookingId): array {
        $db = $this->getdb();
        $stmt = $db->prepare("SELECT * FROM Ticket WHERE bookingId = :bookingId");
        $stmt->execute(['bookingId' => $bookingId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}