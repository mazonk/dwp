<?php
require_once "src/model/services/TicketService.php";

class TicketController {
    private TicketService $ticketService;

    public function __construct() {
        $this->ticketService = new TicketService();
        $seatService = new SeatService();
        $this->ticketService->setSeatService($seatService);
    }

    public function getTicketById(int $id): Ticket|array {
        $ticket = $this->ticketService->getTicketById($id);
        if (is_array($ticket) && isset($ticket['error']) && $ticket['error']) {
            return ['errorMessage' => $ticket['message']];
        }
        return $ticket;
    }

    public function createTickets(array $seatIds, int $ticketTypeId, int $showingId, int $bookingId): array {
        $insertedTicketIds = $this->ticketService->createTickets($seatIds, $ticketTypeId, $showingId, $bookingId);
        if (is_array($insertedTicketIds) && isset($insertedTicketIds["error"]) && $insertedTicketIds["error"]) {
            return ["errorMessage" => $insertedTicketIds["message"]];
        }
        $_SESSION['activeBooking']['showingId'] = $showingId;
        $_SESSION['activeBooking']['ticketIds'] = $insertedTicketIds;
        return $insertedTicketIds;
    }

    public function getTicketsByBookingId(int $bookingId): array {
        $tickets = $this->ticketService->getTicketsByBookingId($bookingId);
        if (isset($tickets['error']) && $tickets['error']) {
            return ['errorMessage' => $tickets['message']];
        }
        return $tickets;
    }

    public function getAllTicketTypes(): array {
        $ticketTypes = $this->ticketService->getAllTicketTypes();
        if (is_array($ticketTypes) && isset($ticketTypes['error']) && $ticketTypes['error']) {
            return ['errorMessage' => $ticketTypes['message']];
        }
        return $ticketTypes;
    }
}