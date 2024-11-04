<?php
include_once "src/model/entity/Ticket.php";

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
}