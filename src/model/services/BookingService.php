<?php
require_once "src/model/entity/Booking.php";
require_once "src/model/services/UserService.php";
require_once "src/model/services/TicketService.php";
require_once "src/model/services/SeatService.php";
require_once "src/model/repositories/BookingRepository.php";

class BookingService {
    private BookingRepository $bookingRepository;
    private UserService $userService;
    private TicketService $ticketService;

    public function __construct() {
        $this->bookingRepository = new BookingRepository();
        $this->userService = new UserService();
        $seatService = new SeatService();
        $this->ticketService = new TicketService();
        $this->ticketService->setSeatService($seatService);
    }

    public function getBookingById(int $bookingId): Booking|array  {
        try {
            $result = $this->bookingRepository->getBookingById($bookingId);
            if ($result['userId'] === null) {
                $tickets = $this->ticketService->getTicketsByBookingId($result['bookingId']);
                if (isset($tickets['error']) && $tickets['error']) {
                    return $tickets;
                }
                return new Booking($result['bookingId'], null, Status::from($result['status']), $tickets);
            }
            else {
                $user = $this->userService->getUserById($result['userId']);
                if (is_array($user) && isset($user['error']) && $user['error']) {
                    return $user;
                }
                $tickets = $this->ticketService->getTicketsByBookingId($result['bookingId']);
                if (isset($tickets['error']) && $tickets['error']) {
                    return $tickets;
                }
                return new Booking($result['bookingId'], $user, Status::from($result['status']), $tickets);
            }
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getBookingsByUserId(int $userId): array {
        try {
            $result = $this->bookingRepository->getBookingsByUserId($userId);
            $bookings = [];
            foreach ($result as $booking) {
                $user = $this->userService->getUserById($booking['userId']);
                if (is_array($user) && isset($user['error']) && $user['error']) {
                    return $user;
                }
                $tickets = $this->ticketService->getTicketsByBookingId($booking['bookingId']);
                if (isset($tickets['error']) && $tickets['error']) {
                    return $tickets;
                }
                $bookings[] = new Booking($booking['bookingId'], $user, Status::from($booking['status']), $tickets);
            }
            return $bookings;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function updateBookingUser(int $bookingId, int $userId): array {
        try {
            $this->bookingRepository->updateBookingUser($bookingId, $userId);
            return ['success' => true];
        } catch (Exception $e) {
          return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getBookingsByShowingId(int $showingId): array {
        try {
            $result = $this->bookingRepository->getBookingsByShowingId($showingId);
            $bookingIds = array_unique(array_column($result, 'bookingId'));
            $bookings = [];
            
            foreach ($bookingIds as $bookingId) {
                $bookingDetails = null;
    
                foreach ($result as $booking) {
                    if ($booking['bookingId'] == $bookingId) {
                        $bookingDetails = $booking;
                        break; // No need to iterate further once the booking is found
                    }
                }
    
                if ($bookingDetails === null) {
                    continue; // Skip if no booking details were found for this ID
                }
    
                $user = $this->userService->getUserById($bookingDetails['userId']);
                if (is_array($user) && isset($user['error']) && $user['error']) {
                    return $user;
                }
    
                $tickets = $this->ticketService->getTicketsByBookingId($bookingId);
                if (isset($tickets['error']) && $tickets['error']) {
                    return $tickets;
                }
    
                $bookings[] = new Booking(
                    $bookingId, 
                    $user, 
                    Status::from($bookingDetails['status']), 
                    $tickets
                );
            }
            
            return $bookings;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function updateBookingStatus(int $bookingId, string $status): array {
        try {
            $this->bookingRepository->updateBookingStatus($bookingId, $status);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function createEmptyBooking($userId, string $status): int|array {
        try {
            $bookingId = $this->bookingRepository->createBooking($userId, Status::from($status));
            return $bookingId;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function rollBackBooking(int $bookingId, array $ticketIds): array {
        $booking = $this->getBookingById($bookingId);
        if (is_array($booking) && isset($booking['error']) && $booking['error']) {
            return ['error' => true, 'message' => $booking['message']];
        } 
        else if ($booking->getStatus() !== Status::PENDING) {
            return ['error' => true, 'message' => 'Booking is not pending.'];
        }
        else {
            $failedTickets = [];
            try {
                foreach ($ticketIds as $ticketId) {
                    $result = $this->ticketService->rollbackTicket($ticketId);
                    if (isset($result['error']) && $result['error']) {
                        $failedTickets[] = $ticketId;
                    }
                }
    
                if (!empty($failedTickets)) {
                    return ["error" => true, "message" => "Failed to roll back all the tickets."];
                }
    
                $this->bookingRepository->rollBackBooking($bookingId);
    
                return ['success' => true];
            } catch (Exception $e) {
                return ["error" => true, "message" => $e->getMessage()];
            } 
        }
    }
}
