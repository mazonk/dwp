<?php
include_once "src/model/entity/Ticket.php";
include_once "src/model/entity/Showing.php";

class TicketRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

//     public function createTicket(Ticket $ticket) {
//         $pdo = $this->getdb();
//         $statement = $pdo->prepare("INSERT INTO tickets (bookingId, seatId) VALUES (:bookingId, :seatId)");
//         $statement->bindValue(':bookingId', $ticket->getBookingId());

// }
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
    $statement = $pdo->prepare("SELECT * FROM tickets WHERE ticketId = :ticketId");
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
}