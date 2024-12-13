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

    // public function createTicket(int $seatId, int $ticketTypeId, int $showingId): int|array {
    //     $insertedTicketId = $this->ticketService->createTicket($seatId, $ticketTypeId, $showingId, $_SESSION['activeBooking']['id']);
    //     if (is_array($insertedTicketId) && isset($insertedTicketId["error"]) && $insertedTicketId["error"]) {
    //         return ["errorMessage" => $insertedTicketId["message"]];
    //     }
    //     $_SESSION['activeBooking']['ticketIds'] += $insertedTicketId;
    //     echo json_encode($insertedTicketId);
    //     return $insertedTicketId;
    // }

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