<?php 
include_once "src/model/database/dbcon/DatabaseConnection.php";

class BookingRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getBookingById(int $bookingId): array {
        $db = $this->getdb();
        try {
        $stmt = $db->prepare("SELECT * FROM Booking WHERE bookingId = :bookingId");
        $stmt->execute(['bookingId' => $bookingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("No booking found.");
        }
        return $result;
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch booking.");
        }
    }

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

    public function getBookingsByShowingId(int $showingId): array {
        $db = $this->getdb();
        try {
            $stmt = $db->prepare("SELECT b.*, t.*
            FROM Booking b
            LEFT JOIN Ticket t ON b.bookingId = t.bookingId
            WHERE t.showingId = :showingId;");
            $stmt->execute(['showingId' => $showingId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No bookings found.");
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch bookings.");
        }
    }

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