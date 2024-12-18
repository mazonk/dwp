<?php
include_once "src/model/services/RoomService.php";

class RoomController {
    private RoomService $roomService;

    public function __construct() {
        $this->roomService = new RoomService();
    }

    public function getRoomsByVenueId(int $venueId): array|Room {
        $result = $this->roomService->getRoomsByVenueId($venueId);
        if (is_array($result) && isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        } 
        return $result;
    }
  }