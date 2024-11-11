<?php
include_once "src/model/entity/Booking.php";
include_once "src/model/services/UserService.php";
include_once "src/model/repositories/BookingRepository.php";

class BookingService {
    private BookingRepository $bookingRepository;
    private UserService $userService;
    public function __construct() {
        $this->bookingRepository = new BookingRepository();
        $this->userService = new UserService();
    }

    public function getBookingById(int $bookingId): Booking |array  {
        try {
            $result = $this->bookingRepository->getBookingById($bookingId);
            $user = $this->userService->getUserById($result['userId']);
            if (is_array($user) && isset($user['error']) && $user['error']) {
                return $user;
            }
            return new Booking($result['bookingId'], $user, Status::from($result['status']));
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
