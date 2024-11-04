<?php
include_once "src/model/entity/Ticket.php";
include_once "src/model/entity/Showing.php";

class TicketRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function createTicket(Ticket $ticket) {
        $pdo = $this->getdb();
        $statement = $pdo->prepare("INSERT INTO tickets (bookingId, seatId) VALUES (:bookingId, :seatId)");
        $statement->bindValue(':bookingId', $ticket->getBookingId());

}

    public function getAllTicketsForShowing(Ticket $ticket, Showing $showing) {
        $pdo = $this->getdb();
        $statement = $pdo->prepare("SELECT * FROM tickets WHERE showingId = :showingId");
        try {
            $statement->execute(array(":showingId" => $showing->getShowingId()));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch tickets");
        }
        return $result;
    }
}