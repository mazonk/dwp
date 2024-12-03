<?php
require_once "src/model/services/TicketService.php";

class TicketController {
    private TicketService $ticketService;

    public function __construct() {
        $this->ticketService = new TicketService();
    }

    public function createTicket(int $seatId, int $ticketTypeId, int $showingId): int|array {
        $insertedTicketId = $this->ticketService->createTicket($seatId, $ticketTypeId, $showingId, $_SESSION['activeBooking']['id']);
        if (is_array($insertedTicketId) && isset($insertedTicketId["error"]) && $insertedTicketId["error"]) {
            return ["errorMessage" => $insertedTicketId["message"]];
        }
        $_SESSION['activeBooking']['ticketIds'] += $insertedTicketId;
        echo json_encode($insertedTicketId);
        return $insertedTicketId;
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