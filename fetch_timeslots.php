<?php
include_once "src/controller/OpeningHourController.php";
include_once "src/controller/ShowingController.php";

if (isset($_POST['venueId'], $_POST['showingDate'], $_POST['movieId'], $_POST['todayDay'], $_POST['duration'])) {
    // Sanitize input
    $venueId = intval(trim($_POST['venueId']));
    $showingDate = htmlspecialchars(trim($_POST['showingDate']));
    $movieId = intval(trim($_POST['movieId']));
    $todayDay = htmlspecialchars(trim($_POST['todayDay']));
    $duration = intval(trim($_POST['duration']));

    $openingHourController = new OpeningHourController();
    $showingController = new ShowingController();

    // Get the venue's opening hours for the specified day
    $openingHour = $openingHourController->getCurrentOpeningHourByDay($todayDay);
    if (is_array($openingHour) && isset($openingHour['errorMessage']) && $openingHour['errorMessage']) {
        echo json_encode(['error' => true, 'message' => $openingHour['errorMessage']]);
        exit;
    }

    $openTime = $openingHour->getOpeningTime();
    $closeTime = $openingHour->getClosingTime();

    // Get unavailable timeslots
    $unavailableTimeslots = $showingController->getUnavailableTimeslotsForMovie($venueId, $movieId, $showingDate);
    if (isset($unavailableTimeslots['errorMessage']) && $unavailableTimeslots['errorMessage']) {
        echo json_encode(['error' => true, 'message' => $unavailableTimeslots['errorMessage']]);
        exit;
    }

    // Calculate all potential timeslots
    $availableTimes = [];
    $currentTime = clone $openTime;

    // Function to round a DateTime object to the nearest 10, 20, 30, 40, 5, 0 minute mark
    function roundToNextSlot(DateTime $time) {
        $minute = (int) $time->format('i');
        $hour = (int) $time->format('H');
        
        // Round minutes to nearest 10, 20, 30, 40, 50 or 0
        $roundedMinute = ceil($minute / 10) * 10;
        if ($roundedMinute == 60) {
            // If rounding goes over 60 minutes, move to the next hour
            $roundedMinute = 0;
            $hour++;
        }

        // Set the rounded time
        $time->setTime($hour, $roundedMinute);

        return $time;
    }

    while ($currentTime <= $closeTime) {
        // Round the current start time
        $currentTime = roundToNextSlot(clone $currentTime);

        // Calculate the end time of the slot by adding the duration of the movie
        $endSlotTime = clone $currentTime;
        $endSlotTime->modify("+{$duration} minutes");

        // Round the end time
        $endSlotTime = roundToNextSlot($endSlotTime);

        // Ensure the slot ends before the venue's closing time
        if ($endSlotTime > $closeTime) {
            break;
        }

        // Check if the timeslot overlaps with unavailable times
        $isAvailable = true;
        foreach ($unavailableTimeslots as $slot) {
            $unavailableStart = new DateTime($slot['showingTime']);
            $unavailableEnd = clone $unavailableStart;
            $unavailableEnd->modify("+{$duration} minutes");

            if (
                ($currentTime >= $unavailableStart && $currentTime < $unavailableEnd) || // Overlap start
                ($endSlotTime > $unavailableStart && $endSlotTime <= $unavailableEnd) || // Overlap end
                ($currentTime <= $unavailableStart && $endSlotTime >= $unavailableEnd)  // Enclose
            ) {
                $isAvailable = false;
                break;
            }
        }

        if ($isAvailable) {
            $availableTimes[] = [
                'startTime' => $currentTime->format('H:i'),
                'endTime' => $endSlotTime->format('H:i'),
            ];
        }

        // Move to the next potential timeslot (by adding duration, no need to round again since it's already done)
        $currentTime->modify("+{$duration} minutes");
    }

    // Return available times as JSON
    echo json_encode(['success' => true, 'availableTimes' => $availableTimes]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}