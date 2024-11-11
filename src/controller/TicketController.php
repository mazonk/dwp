<?php
include_once "src/model/repositories/TicketRepository.php";
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/services/TicketService.php";
include_once "src/model/entity/Seat.php";
include_once "src/model/entity/Ticket.php";
include_once "src/model/entity/TicketType.php";

class TicketController {
    private TicketService $ticketService;
    private TicketRepository $ticketRepository;

    public function __construct() {
        $this->ticketService = new TicketService();
        $this->ticketRepository = new TicketRepository();
    }

    // public function getAllTicketsForShowing(int $showingId, int $venueId): array {
    //     $tickets = [];
    //     try {
    //     $tickets = $this->ticketService->getAllTicketsForShowing($showingId, $venueId);
    //     } catch (Exception $e) {
    //         return ['error' => true, 'message' => $e->getMessage()];
    //     }
    //     return $tickets;  
    // }
}