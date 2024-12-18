<?php
include_once "src/controller/MovieController.php";
include_once "src/controller/ShowingController.php";
include_once "src/controller/VenueController.php";

if (isset($_GET['selectedMovie']) && is_numeric($_GET['selectedMovie'])) {
    $movieId = intval($_GET['selectedMovie']);
    $showingController = new ShowingController();
    $movieController = new MovieController();
    $venueController = new VenueController();
    $allVenues = $venueController->getAllVenues();
    $movie = $movieController->getMovieById($movieId);
    $showings = $showingController->getShowingsForMovieAdmin($movieId);

    // Filter out past showings
    $today = new DateTime();
    $showings = array_filter($showings, function ($showing) use ($today) {
        return new DateTime($showing['showingDate']) >= $today;
    });
} else {
    $showings = ['errorMessage' => 'Invalid or missing movie ID.'];
}

// Extract unique dates for filtering
$dates = [];
if (!isset($showings['errorMessage'])) {
    foreach ($showings as $showing) {
        $dates[] = $showing['showingDate'];
    }
    $dates = array_unique($dates);
    sort($dates);
}

$addShowingData = [
    'movieId' => $movieId,
    'duration' => $movie->getDuration()
];
?>

<div class="p-6 min-h-screen">
    <div class="w-full">
        <a href="?section=showings" class="text-blue-500 underline mb-4 block"><-Back to Movies</a>
        <h1 class="text-2xl font-bold mb-4">Showings for <?php echo htmlspecialchars($movie->getTitle()); ?>:</h1>

        <?php if (isset($showings['errorMessage'])) { ?>
            <div class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md">
                <?php echo htmlspecialchars($showings['errorMessage']); ?>
            </div>
        <?php } else { ?>

        <!-- Filters -->
        <div class="flex flex-row gap-[3rem] align-baseline">
            <!-- Venue Filter Dropdown -->
            <div class="mb-6">
                <label for="venueFilter" class="block font-medium mb-2">Filter by Venue:</label>
                <select id="venueFilter" class="bg-bgSemiDark text-white border border-gray-300 p-[0.68rem] rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    <option value="">All Venues</option>
                    <?php foreach ($allVenues as $venue) { ?>
                        <option value="<?php echo htmlspecialchars($venue->getVenueId()); ?>">
                            <?php echo htmlspecialchars($venue->getName()); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Date Filter Dropdown -->
            <div class="mb-6">
                <label for="dateFilter" class="block font-medium mb-2">Filter by Date:</label>
                <input id="dateFilter" type="date" class="bg-bgSemiDark text-white border border-gray-300 p-2 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                <button id="clearFilterButton" class="ml-2 bg-red-500 text-gray-100 p-2 rounded-md shadow-sm">Clear date</button>
            </div>

            <!-- Add Showing Button -->
            <div class="ml-auto flex items-center">
                <button id="addShowingButton" data-addshowing="<?php echo htmlspecialchars(json_encode($addShowingData)); ?>" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add Showing</button>
            </div>
        </div>

        <div id="showingsList" class="grid grid-cols-4 gap-6">
            <?php foreach ($showings as $showing) { ?>
                <div  
                    class="bg-bgSemiDark p-4 rounded-lg shadow-md border border-borderDark showing-item cursor-pointer" 
                    data-date="<?php echo htmlspecialchars($showing['showingDate']); ?>" 
                    data-venue="<?php echo htmlspecialchars($showing['venueId']); ?>"
                    data-movie="<?php echo htmlspecialchars($showing['movieId']); ?>">
                    
                    <!-- today label -->
                    <?php if (new DateTime($showing['showingDate']) == $today) { ?>
                        <span class="bg-primary text-textDark text-xs font-semibold px-2 py-1 rounded-full mb-2 inline-block">Today</span>
                    <?php } ?>
                    <h3 class="text-lg font-semibold text-white mb-2">
                        <?php echo $showing['showingDate']; ?> at <?php echo $showing['showingTime']; ?>
                    </h3>
                    <!-- Edit and delete button -->
                    <button onclick="openEditShowingModal" class='py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
                        Edit
                    </button>
                    <button onclick="openDeleteShowingModal" class='bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
                        Delete
                    </button>
                </div>

            <?php } ?>
        </div>

        <div id="noShowingsMessage" class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md hidden">
            No showings available for the selected filters. Please clear the filter, or select different options.
        </div>
        <?php } ?>
    </div>
    
    <!-- Add showing modal -->
    <div id="addShowingModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Showing</h2>
                <form id="addShowingForm" class="text-textLight">
                    <!-- Venue -->
                    <div class="mb-4">
                        <label for="addShowingVenueInput" class="block text-sm font-medium text-textLight">Venue</label>
                        </label>
                        <select id="addShowingVenueInput" name="addShowingVenueInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue</option>
                            <?php foreach ($allVenues as $venue) { ?>
                                <option value="<?php echo htmlspecialchars($venue->getVenueId()); ?>">
                                    <?php echo htmlspecialchars($venue->getName()); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <p id="error-add-showing-venue" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Date -->
                    <div class="mb-4">
                        <label for="addShowingDateInput" class="block text-sm font-medium text-textLight">Date</label>
                        </label>
                        <input type="date" id="addShowingDateInput" name="addShowingDateInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                        <p id="error-add-showing-date" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Time -->
                    <div class="mb-4">
                        <label for="addShowingTimeInput" class="block text-sm font-medium text-textLight">Time</label>
                        <select id="addShowingTimeInput" name="addShowingTimeInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue and date first</option>
                        </select>
                        <p id="error-add-showing-time" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Room -->
                    <div class="mb-4">
                        <label for="addShowingRoomInput" class="block text-sm font-medium text-textLight">Room</label>
                        <select id="addShowingRoomInput" name="addShowingRoomInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue, date, and time first</option>
                        </select>
                        <p id="error-add-showing-room" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="submit" id="saveAddShowingButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                        <button type="button" id="cancelAddShowingButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>      
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const venueFilter = document.getElementById('venueFilter');
        const dateFilter = document.getElementById('dateFilter');
        const clearFilterButton = document.getElementById('clearFilterButton');
        const noShowingsMessage = document.getElementById('noShowingsMessage');
        const showings = document.querySelectorAll('.showing-item');

        function applyFilters() {
            const selectedVenue = venueFilter.value;
            const selectedDate = dateFilter.value;
            let hasVisibleShowings = false;

            showings.forEach(showing => {
                const showingVenue = showing.dataset.venue;
                const showingDate = showing.dataset.date;

                const matchesVenue = !selectedVenue || showingVenue === selectedVenue;
                const matchesDate = !selectedDate || showingDate === selectedDate;

                if (matchesVenue && matchesDate) {
                    showing.style.display = "block";
                    hasVisibleShowings = true;
                } else {
                    showing.style.display = "none";
                }
            });

            if (hasVisibleShowings) {
                noShowingsMessage.classList.add('hidden');
            } else {
                noShowingsMessage.classList.remove('hidden');
            }
        }


        venueFilter.addEventListener('change', applyFilters);
        dateFilter.addEventListener('change', applyFilters);

        clearFilterButton.addEventListener('click', function () {
            dateFilter.value = '';
            showings.forEach(showing => {
                showing.style.display = "block";
            });
            noShowingsMessage.classList.add('hidden');
        });

        // Add showing
        const addShowingButton = document.getElementById('addShowingButton');
        const addShowingModal = document.getElementById('addShowingModal');
        const cancelAddShowingButton = document.getElementById('cancelAddShowingButton');
        let showingData;

        addShowingButton.addEventListener('click', () => {
            showingData = addShowingButton.dataset.addshowing;
            showingData = JSON.parse(showingData);
            addShowingModal.classList.remove('hidden');
        });

        cancelAddShowingButton.addEventListener('click', () => {
            addShowingModal.classList.add('hidden');
        });

        const addShowingVenueInput = document.getElementById('addShowingVenueInput');
        const addShowingVenueError = document.getElementById('error-add-showing-venue');
        const addShowingDateInput = document.getElementById('addShowingDateInput');
        const addShowingDateError = document.getElementById('error-add-showing-date');
        const addShowingTimeInput = document.getElementById('addShowingTimeInput');
        const addShowingTimeError = document.getElementById('error-add-showing-time');
        const addShowingRoomInput = document.getElementById('addShowingRoomInput');
        const addShowingRoomError = document.getElementById('error-add-showing-room');

        function fetchRequest(route, data) {
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
            xhr.open('POST', `${baseRoute}fetch-${route}`, true);

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.response);
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }

                    if (response.success) {
                        if (route == "timeslots") {
                            addShowingTimeInput.innerHTML = '<option value="" disabled selected>Select a time slot</option>';
                            response.availableTimes.forEach((timeSlot) => {
                                const option = document.createElement('option');
                                option.value = timeSlot.startTime;
                                option.textContent = `${timeSlot.startTime} - ${timeSlot.endTime}`;
                                addShowingTimeInput.appendChild(option);
                            });
                        } 
                        else if (route == "rooms") {
                            addShowingRoomInput.innerHTML = '<option value="" disabled selected>Select a room</option>';
                            response.availableRooms.forEach((room) => {
                                const option = document.createElement('option');
                                option.value = room.roomNumber;
                                option.textContent = `Room ${room.roomNumber}`;
                                addShowingRoomInput.appendChild(option);
                            });
                        }
                        
                    } else {
                        if (route == "timeslots") {
                            addShowingTimeInput.innerHTML = '<option value="" disabled>No available slots</option>';
                        }
                        else if (route == "rooms") {
                            addShowingRoomInput.innerHTML = '<option value="" disabled>No available rooms for this timeslot</option>';
                        }
                    }
                }
            };
            // Send data as URL-encoded string
            const params = Object.keys(data)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`)
                .join('&');
            xhr.send(params);
        }

        function fetchAvailableTimeslots() {
            const venueId = addShowingVenueInput.value;
            const showingDate = addShowingDateInput.value;

            if (!venueId || !showingDate) {
                return;
            } 
            const { duration, movieId } = showingData;

            // Create a Date object
            const date = new Date(showingDate);
            // Get the weekday as a number (0 for Sunday, 1 for Monday, etc.)
            const dayNumber = date.getDay();
            // Map the day number to weekday names
            const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const weekday = weekdays[dayNumber];

            const data = {
                venueId: venueId,
                showingDate: showingDate,
                duration: duration,
                movieId: movieId,
                weekday: weekday
            };

            fetchRequest('timeslots', data);
        }

        function fetchAvailableRooms() {
            const venueId = addShowingVenueInput.value;
            const showingDate = addShowingDateInput.value;
            const showingTime = addShowingTimeInput.value;

            if (!venueId || !showingDate) {
                return;
            } 
            const { duration, movieId } = showingData;

            // Create a Date object
            const date = new Date(showingDate);
            // Get the weekday as a number (0 for Sunday, 1 for Monday, etc.)
            const dayNumber = date.getDay();
            // Map the day number to weekday names
            const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const weekday = weekdays[dayNumber];

            const data = {
                venueId: venueId,
                showingDate: showingDate,
                duration: duration,
                movieId: movieId,
                weekday: weekday
            };

            fetchRequest('timeslots', data);
        }

        addShowingVenueInput.addEventListener('change', fetchAvailableTimeslots);
        addShowingDateInput.addEventListener('change', fetchAvailableTimeslots);
    });
</script>
