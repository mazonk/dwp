<?php
include_once "src/model/entity/Booking.php";
include_once "src/model/services/UserService.php";
include_once "src/model/services/TicketService.php";
include_once "src/model/services/SeatService.php";
include_once "src/model/repositories/BookingRepository.php";

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

    // public function getBookingById(int $bookingId): Booking |array  {
    //     try {
    //         $result = $this->bookingRepository->getBookingById($bookingId);
    //         $user = $this->userService->getUserById($result['userId']);
    //         if (is_array($user) && isset($user['error']) && $user['error']) {
    //             return $user;
    //         }
    //         return new Booking($result['bookingId'], $user, Status::from($result['status']));
    //     } catch (Exception $e) {
    //         return ['error' => true, 'message' => $e->getMessage()];
    //     }
    // }

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

    public function updateBookingStatus(int $bookingId, string $status): array {
        try {
            $this->bookingRepository->updateBookingStatus($bookingId, $status);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
