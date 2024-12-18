<?php
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Log errors to 'error.log' in the current directory
include_once "src/controller/ShowingController.php";
include_once "src/controller/RoomController.php";

if (isset($_POST['venueId'], $_POST['showingDate'], $_POST['showingTime'])) {
    // Sanitize input
    $venueId = intval(trim($_POST['venueId']));
    $showingDate = htmlspecialchars(trim($_POST['showingDate']));
    $showingTime = htmlspecialchars(trim($_POST['showingTime']));

    // Split the showing time into start and end times
    $showingTime = explode("-", $showingTime);
    $showingTimeStart = new DateTime($showingTime[0]); // Start time
    $showingTimeEnd = new DateTime($showingTime[1]);   // End time

    $showingController = new ShowingController();
    $roomController = new RoomController();

    // Get unavailable rooms for the venue on the given date
    $unavailableRooms = $showingController->getUnavailableRoomsForAVenueAndDay($venueId, $showingDate);
    if (isset($unavailableRooms['errorMessage']) && $unavailableRooms['errorMessage']) {
        echo json_encode(['error' => true, 'message' => $unavailableRooms['errorMessage']]);
        exit;
    }

    // Get all rooms for the venue
    $rooms = $roomController->getRoomsByVenueId($venueId);
    if (is_array($rooms) && isset($rooms['errorMessage']) && $rooms['errorMessage']) {
        echo json_encode(['error' => true, 'message' => $rooms['errorMessage']]);
        exit;
    }

    // Filter available rooms
    $availableRooms = [];
    foreach ($rooms as $room) {
        $isUnavailable = false;

        // Check if the room is in the unavailable list
        foreach ($unavailableRooms as $unavailableRoom) {
            if ($room->getRoomId() == $unavailableRoom['roomId']) {
                // Convert unavailable times to DateTime for comparison
                $unavailableStart = new DateTime($unavailableRoom['showingTime']);
                $unavailableEnd = clone $unavailableStart;
                $unavailableEnd->modify("+{$unavailableRoom['duration']} minutes");

                // Check for overlap
                if (
                    ($showingTimeStart >= $unavailableStart && $showingTimeStart < $unavailableEnd) || // Overlaps start
                    ($showingTimeEnd > $unavailableStart && $showingTimeEnd <= $unavailableEnd) ||     // Overlaps end
                    ($showingTimeStart <= $unavailableStart && $showingTimeEnd >= $unavailableEnd)    // Encloses
                ) {
                    $isUnavailable = true;
                    break;
                }
            }
        }

        // If the room is not unavailable, add it to the available rooms
        if (!$isUnavailable) {
            $availableRooms[] = [
                'roomId' => $room->getRoomId(),
                'roomNumber' => $room->getRoomNumber(),
            ];
        }
    }

    // Return available rooms
    echo json_encode(['success' => true, 'availableRooms' => $availableRooms]);
    exit;
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid input.']);
  exit;
}