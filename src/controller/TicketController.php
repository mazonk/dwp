<?php
include_once "src/model/repositories/TicketRepository.php";
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/services/TicketService.php";
include_once "src/model/entity/Seat.php";
include_once "src/model/entity/Ticket.php";
include_once "src/model/entity/TicketType.php";

class TicketController {
    private TicketService $ticketService;

    public function __construct() {
        $this->ticketService = new TicketService();
    }

    public function getAllAvailableSeats() {


}