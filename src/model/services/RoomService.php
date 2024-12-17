<?php
require_once "src/model/repositories/RoomRepository.php";
require_once "src/model/entity/Room.php";

class RoomService {
    private RoomRepository $roomRepository;
    private VenueService $venueService;

    public function __construct() {
        $this->roomRepository = new RoomRepository();
        $this->venueService = new VenueService();
    }

    public function getRoomById(int $roomId): array|Room {
        try {
            $result = $this->roomRepository->getRoomById($roomId);

            // Get the venue associated with the room
            $venue = $this->venueService->getVenueById($result['venueId']);
            if (is_array($venue) && isset($venue['error']) && $venue['error']) {
                return $venue; //return the errors if there are any
            } else {
                return new Room($result['roomId'], $result['roomNumber'], $venue);
            }
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }
}