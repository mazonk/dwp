<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/entity/Ticket.php";
require_once "src/model/entity/Showing.php";

class TicketRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

public function getAllTicketsForShowing(int $showingId): array {
    $pdo = $this->getdb();
    $statement = $pdo->prepare("SELECT * FROM Ticket WHERE showingId = :showingId");
    try {
        $statement->execute([':showingId' => $showingId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result; // Return empty array if no tickets found
    } catch (PDOException $e) {
        throw new PDOException("Unable to fetch tickets: " . $e->getMessage());
    }
}

public function getTicketsByBookingId(int $bookingId): array {
    $pdo = $this->getdb();
    $statement = $pdo->prepare("SELECT * FROM Ticket WHERE bookingId = :bookingId");
    try {
        $statement->execute([':bookingId' => $bookingId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("No tickets found.");
        }
        return $result;
    } catch (PDOException $e) {
        throw new PDOException("Unable to fetch tickets: " . $e->getMessage());
    }
}

public function getTicketTypeById(int $ticketTypeId): array {
    $pdo = $this->getdb();
    $statement = $pdo->prepare("SELECT * FROM TicketType WHERE ticketTypeId = :ticketTypeId");
    try {
        $statement->execute([":ticketTypeId"=> $ticketTypeId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("No ticket type found.");
        }
        return $result;
    } catch (PDOException $e) {
        throw new PDOException("Unable to fetch ticket type.");
    }
}

public function getAllTicketTypes(): array {
    $pdo = $this->getdb();
    $statement = $pdo->prepare("SELECT * FROM TicketType");
    try {
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("No ticket types found.");
        }
        return $result;
    } catch (PDOException $e) {
        throw new PDOException("Unable to fetch ticket types.");
    }
}

public function getTicketById(int $ticketId): array {
    $pdo = $this->getdb();
    $statement = $pdo->prepare("SELECT * FROM Ticket WHERE ticketId = :ticketId");
    try {
        $statement->execute([':ticketId' => $ticketId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("No ticket found.");
        }
        return $result;
    } catch (PDOException $e) {
        throw new PDOException("Unable to fetch ticket.");
    }
}

public function createTicket(int $seatId, int $ticketTypeId, int $showingId, int $bookingId): int {
    $db = $this->getdb();
    $statement = $db->prepare("INSERT INTO Ticket (seatId, ticketTypeId, showingId, bookingId) VALUES (:seatId, :ticketTypeId, :showingId, :bookingId)");
    try {
        $statement->execute([
            ':seatId' => $seatId,
            ':ticketTypeId' => $ticketTypeId,
            ':showingId' => $showingId,
            ':bookingId' => $bookingId
        ]);
        return (int)$db->lastInsertId();
    } catch (PDOException $e) {
        throw new PDOException("Unable to create ticket: ". $e->getMessage());
    }
}

public function rollbackTicket(int $ticketId): bool {
    $db = $this->getdb();
    $statement = $db->prepare("DELETE FROM Ticket WHERE ticketId = :ticketId");
    try {
        return $statement->execute([':ticketId' => $ticketId]);
    } catch (PDOException $e) {
        throw new PDOException("Unable to rollback ticket: ". $e->getMessage());
    }
}
}