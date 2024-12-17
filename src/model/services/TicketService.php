<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/repositories/TicketRepository.php";
require_once "src/model/services/SeatService.php";
require_once "src/model/services/ShowingService.php";
require_once "src/model/entity/Ticket.php";
require_once "src/model/entity/TicketType.php";

class TicketService {
    private TicketRepository $ticketRepository;
    private ?SeatService $seatService;
    private ShowingService $showingService;
    private PDO $db;

    public function __construct() {
        $this->ticketRepository = new TicketRepository();
        $this->seatService = null;
        $this->showingService = new ShowingService();
        $this->db = $this->getdb();
    }

    private function getdb() {
        return DatabaseConnection::getInstance(); // singleton
    }
    
    public function setSeatService(SeatService $seatService): void {
        $this->seatService = $seatService;
    }

    private function mapTicket(array $ticketData): array|Ticket {
        // Fetch seat details
        $seat = $this->seatService?->getSeatById($ticketData["seatId"]);
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
        $showing = $this->showingService->getShowingById($ticketData["showingId"]);
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

    public function getAllTicketsForShowing(int $showingId): array {
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
        $tickets = [];
        try {
            $result = $this->ticketRepository->getTicketsByBookingId($bookingId);
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

    public function getTicketById(int $id): array|Ticket {
        try {
            $result = $this->ticketRepository->getTicketById($id);
            $ticket = $this->mapTicket($result);
            if (is_array($ticket) && isset($ticket["error"]) && $ticket["error"]) {
                return $ticket; // Return error array
            }
            return $ticket;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function createTickets(array $seatIds, int $ticketTypeId, int $showingId, int $bookingId): array {
        try {
            // Start transaction
            $this->db->beginTransaction();

            $insertedIds = [];
            foreach ($seatIds as $seatId) {
                $insertedId = $this->ticketRepository->createTicket($seatId, $ticketTypeId, $showingId, $bookingId);
                if ($insertedId === false) {
                    // Roll back on failed to insert 
                    $this->db->rollBack();
                    return ['error' => true, 'message' => "Failed to create ticket for seat {$seatId}"];
                }
                $insertedIds[] = $insertedId;
            }
            $this->db->commit();
            return $insertedIds;
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function rollbackTicket(int $ticketId) {
        try {
            return $this->ticketRepository->rollbackTicket($ticketId);
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getAllTicketTypes(): array {
        try {
            $result = $this->ticketRepository->getAllTicketTypes();
            $ticketTypes = [];
            foreach ($result as $ticketTypeData) {
                $ticketTypes[] = new TicketType(
                    $ticketTypeData["ticketTypeId"],
                    $ticketTypeData["name"],
                    $ticketTypeData["price"],
                    $ticketTypeData["description"]
                );
            }
            return $ticketTypes;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

}