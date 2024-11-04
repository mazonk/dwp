<?php
include_once "src/model/repositories/TicketRepository.php";
include_once "src/model/repositories/BookingRepository.php";
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/entity/Ticket.php";

class TicketService {
    private TicketRepository $ticketRepository;
    private SeatRepository $seatRepository;
    private BookingRepository $bookingRepository;

    public function __construct() {
        $this->ticketRepository = new TicketRepository();
        $this->seatRepository = new SeatRepository();
        $this->bookingRepository = new BookingRepository();
    }

    public function getAllAvailableSeats () {
        
}