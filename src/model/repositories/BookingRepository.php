<?php 
include_once "src/model/database/dbcon/DatabaseConnection.php";

class BookingRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }
    // public function bookSeat(int $seatId, int $showingId, int $userId): bool {
    //     $db = $this->getdb();
    //     $stmt = $db->prepare("SELECT * FROM Ticket WHERE seatId = :seatId AND showingId = :showingId");
    //     $stmt->execute(['seatId' => $seatId, 'showingId' => $showingId]);
    //     if ($stmt->rowCount() > 0) {
    //         return false; // Seat is already booked
    //     }

    //     // Book the seat
    //     $stmt = $db->prepare("INSERT INTO Ticket (seatId, showingId, userId) VALUES (:seatId, :showingId, :userId)");
    //     return $stmt->execute(['seatId' => $seatId, 'showingId' => $showingId, 'userId' => $userId]);
    // }
    // public function getBookingById(int $bookingId): array {
    //     $db = $this->getdb();
    //     try {
    //     $stmt = $db->prepare("SELECT * FROM Booking WHERE bookingId = :bookingId");
    //     $stmt->execute(['bookingId' => $bookingId]);
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if (empty($result)) {
    //         throw new Exception("No booking found.");
    //     }
    //     return $result;
    //     } catch (PDOException $e) {
    //         throw new PDOException("Unable to fetch booking.");
    //     }
    // }

    public function getBookingsByUserId(int $userId): array {
        $db = $this->getdb();
        try {
            $stmt = $db->prepare("SELECT * FROM Booking WHERE userId = :userId");
            $stmt->execute(['userId' => $userId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No bookings found.");
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch bookings.");
        }
    }

    // public function getAllSeatsForBooking(int $bookingId): array {
    //     $db = $this->getdb();
    //     $stmt = $db->prepare("SELECT * FROM Ticket WHERE bookingId = :bookingId");
    //     $stmt->execute(['bookingId' => $bookingId]);
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    public function createBooking($userId, Status $status): int {
        $db = $this->getdb();
        try {
            $stmt = $db->prepare("INSERT INTO Booking (userId, status) VALUES (:userId, :status)");
            $stmt->execute(['userId' => $userId, 'status' => $status->value]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Unable to create booking.");
        }
    }

    public function rollBackBooking($bookingId){
        $db = $this->getdb();
        try {
            $stmt = $db->prepare("UPDATE Booking SET status = 'failed' WHERE bookingId = :bookingId");
            return $stmt->execute(['bookingId' => $bookingId]);
        } catch (PDOException $e) {
            throw new PDOException("Unable to rollback booking.");
        }
    }

    public function updateBookingUser(int $bookingId, int $userId): void {
        $db= $this->getdb();
        $query = $db->prepare("UPDATE Booking SET userId = :userId WHERE bookingId = :bookingId");
        try {
            $query->execute(array(
                'bookingId' => $bookingId,
                'userId' => $userId
            ));
        } catch (PDOException $e) {
            throw new PDOException('Failed to update userId for booking.');
        }
    }

    public function updateBookingStatus(int $bookingId, string $status): void {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE Booking SET status = :status WHERE bookingId = :bookingId");
        
        try {
            $query->execute(array(
                'bookingId' => $bookingId,
                'status' => $status
            ));
        } catch (PDOException $e) {
            throw new PDOException('Failed to update booking status.');
        }
    }
}