<?php
include_once "src/model/repositories/TicketRepository.php";
include_once "src/model/services/SeatService.php";
include_once "src/model/services/BookingService.php";
include_once "src/model/services/ShowingService.php";
include_once "src/model/entity/Ticket.php";

class TicketService {
    private TicketRepository $ticketRepository;
    private SeatService $seatService;
    private ShowingService $showingService;
    private BookingService $bookingService;

    public function __construct() {
        $this->ticketRepository = new TicketRepository();
        $this->seatService = new SeatService();
        $this->showingService = new ShowingService();
        $this->bookingService = new BookingService();
    }

    public function getAvailableSeats(int $showingId, int $venueId): array {
        try {
            // Fetch all seats for the given showing and venue
            $seats = $this->seatService->getAllSeatsForShowing($showingId, $venueId);
            if (isset($seats["error"]) && $seats["error"]) {
                return $seats;
            }
            $seatsIds = [];
            foreach ($seats as $seat) {
                array_push($seatsIds, $seat->getSeatId());
            }
            // Fetch all booked tickets for the given showing
            $tickets = $this->getAllTicketsForShowing($showingId, $venueId);
            // Extract booked seat IDs
            $bookedSeatIds = array_map(function($ticket) {
                return $ticket['seatId']; // Adjust based on your Ticket structure
            }, $tickets);

            // Filter out the available seats
            $availableSeats = array_filter($seats, function($seat) use ($bookedSeatIds) {
                return !in_array($seat['seatId'], $bookedSeatIds);
            });
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }

        return $availableSeats;
    }

    public function getAllTicketsForShowing(int $showingId, int $venueId): array {
        try {
            $result = $this->ticketRepository->getAllTicketsForShowing($showingId, $venueId);
            $tickets = [];
            $seat = $this->seatService->getSeatById($result["seatId"]);
            if (isset($seat["error"]) && $seat["error"]) {
                return $seat;
            }
            $ticketType = $this->ticketRepository->getTicketTypeById($result["ticketTypeId"]);
            if (isset($ticketType["error"]) && $ticketType["error"]) {
                return $ticketType;
            }
            $showing = $this->showingService->getShowingById($showingId, $venueId);
            if (isset($showing["error"]) && $showing["error"]) {
                return $showing;
            }
            foreach ($result as $ticket) {
                $tickets[] = new Ticket($result["ticketId"], $seat, $ticketType, $showing, $this->bookingService->getBookingById($result["bookingId"]));
            }
            return $tickets;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }

    }
}