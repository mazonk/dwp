<?php
include_once "src/model/repositories/TicketRepository.php";
include_once "src/model/services/SeatService.php";
include_once "src/model/services/BookingService.php";
include_once "src/model/services/ShowingService.php";
include_once "src/model/entity/Ticket.php";
include_once "src/model/entity/TicketType.php";

class TicketService {
    private TicketRepository $ticketRepository;
    private ?SeatService $seatService;
    private ShowingService $showingService;
    private BookingService $bookingService;

    public function __construct() {
        $this->ticketRepository = new TicketRepository();
        $this->seatService = null;
        $this->showingService = new ShowingService();
        $this->bookingService = new BookingService();
    }
    
    public function setSeatService(SeatService $seatService): void {
        $this->seatService = $seatService;
    }

    private function mapTicket(array $ticketData): array|Ticket {
        // Fetch seat details
        $seat = $this->seatService->getSeatById($ticketData["seatId"]);
        if (is_array($seat) && isset($seat["error"]) && $seat["error"]) {
            return $seat;
        }

        // Fetch ticket type details
        $ticketTypeResult = $this->ticketRepository->getTicketTypeById($ticketData["ticketTypeId"]);
        if (is_array($ticketTypeResult) && isset($ticketTypeResult["error"]) && $ticketTypeResult["error"]) {
            return $ticketTypeResult;
        }
        $ticketType = new TicketType(
            $ticketTypeResult["ticketTypeId"],
            $ticketTypeResult["name"],
            $ticketTypeResult["price"],
            $ticketTypeResult["description"]
        );

        // Fetch showing details
        $showing = $this->showingService->getShowingById($ticketData["showingId"], $ticketData["venueId"]);
        if (is_array($showing) && isset($showing["error"]) && $showing["error"]) {
            return $showing;
        }

        // Create and return the Ticket object
        return new Ticket(
            $ticketData["ticketId"],
            $seat,
            $ticketType,
            $showing
        );
    }

    public function getAllTicketsForShowing(int $showingId, int $venueId): array {
        try {
            $result = $this->ticketRepository->getAllTicketsForShowing($showingId);
            $tickets = [];
            foreach ($result as $ticketData) {
                $ticket = $this->mapTicket($ticketData);
                if (is_array($ticket) && isset($ticket["error"]) && $ticket["error"]) {
                    return $ticket; // Return error array
                }
                $tickets[] = $ticket;
            }

            return $tickets;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getTicketsByBookingId(int $bookingId): array {
        try {
            $result = $this->ticketRepository->getTicketsByBookingId($bookingId);
            $tickets = [];
            foreach ($result as $ticketData) {
                $ticket = $this->mapTicket($ticketData);
                if (is_array($ticket) && isset($ticket["error"]) && $ticket["error"]) {
                    return $ticket; // Return error array
                }
                $tickets[] = $ticket;
            }

            return $tickets;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}