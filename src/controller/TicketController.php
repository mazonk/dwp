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
    private SeatRepository $seatRepository;

    public function __construct() {
        $this->ticketService = new TicketService();
        $this->ticketRepository = new TicketRepository();
        $this->seatRepository = new SeatRepository();
    }

    public function getAllAvailableSeats(int $showingId, int $venueId): array {
        try {
            // Fetch all seats for the given showing and venue
            $seats = $this->seatRepository->getAllSeatsForShowing($showingId, $venueId);
            if (empty($seats)) {
                return [];
            }
    
            // Fetch all booked tickets for the given showing
            $tickets = $this->ticketRepository->getAllTicketsForShowing($showingId, $venueId);
            // Extract booked seat IDs from tickets
            $bookedSeatIds = array_map(function($ticket) {
                return $ticket['seatId']; // Adjust based on your Ticket structure
            }, $tickets);
    
            // Filter out the available seats
            $availableSeats = array_filter($seats, function($seat) use ($bookedSeatIds) {
                return !in_array($seat['id'], $bookedSeatIds);
            });
    
            if (empty($availableSeats)) {
                throw new Exception("No available seats found for this showing!");
            }
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
        return $availableSeats;
    }

    public function getAllTicketsForShowing(int $showingId, int $venueId): array {
        $tickets = [];
        try {
        $tickets = $this->ticketService->getAllTicketsForShowing($showingId, $venueId);
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
        return $tickets;  
    }
}