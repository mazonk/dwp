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

    public function getAllTicketsForShowing(int $showingId, int $venueId): array
    {
        try {
            $result = $this->ticketRepository->getAllTicketsForShowing($showingId);
            $tickets = [];
            foreach ($result as $ticket) {

                $seat = $this->seatService->getSeatById($ticket["seatId"]);
                if (is_array($seat) && isset($seat["error"]) && $seat["error"]) {
                    return $seat;
                }
                $ticketTypeResult = $this->ticketRepository->getTicketTypeById($ticket["ticketTypeId"]);
                if (is_array($ticketTypeResult) && isset($ticketTypeResult["error"]) && $ticketTypeResult["error"]) {
                    return $ticketTypeResult;
                }
                $ticketType = new TicketType($ticketTypeResult["ticketTypeId"], $ticketTypeResult["name"], $ticketTypeResult["price"], $ticketTypeResult["description"]);
                $showing = $this->showingService->getShowingById($showingId, $venueId);
                if (is_array($showing) && isset($showing["error"]) && $showing["error"]) {
                    return $showing;
                }
                $booking = $this->bookingService->getBookingById($ticket["bookingId"]);
                if (is_array($booking) && isset($booking["error"]) && $booking["error"]) {
                    return $booking;
                }
                $tickets[] = new Ticket($ticket["ticketId"], $seat, $ticketType, $showing, $booking);
            }

            return $tickets;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
