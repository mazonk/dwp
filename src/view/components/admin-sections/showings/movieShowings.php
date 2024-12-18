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
    $showings = $showingController->getRelevantShowingsForMovie($movieId);
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

$movieData = [
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
                <button id="addShowingButton" data-add-showing="<?php echo htmlspecialchars(json_encode($movieData)); ?>" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add Showing</button>
            </div>
        </div>

        <div id="showingsList" class="grid grid-cols-4 gap-6">
            <?php foreach ($showings as $showing) { 
                $editShowingData = [
                    'showingId' => $showing['showingId'],
                    'venueId' => $showing['venueId'],
                    'showingDate' => $showing['showingDate'],
                    'showingTime' => $showing['showingTime'],
                    'movieData' => $movieData,
                    'roomId' => $showing['roomId'],
                    'roomNumber' => $showing['roomNumber']
                ];
                
                ?>
                <div  
                    class="bg-bgSemiDark p-4 rounded-lg shadow-md border border-borderDark showing-item cursor-pointer">
                    <!-- Today label -->
                    <?php if ($showing['showingDate'] == date('Y-m-d')) { ?>
                        <span class="bg-primary text-textDark text-xs font-semibold px-2 py-1 rounded-full mb-2 inline-block">Today</span>
                    <?php } ?>
                    <h3 class="text-lg font-semibold text-white mb-2">
                        <?php echo $showing['showingDate']; ?> at <?php echo $showing['showingTime']; ?>
                    </h3>
                    <!-- Edit and delete button -->
                    <button data-edit-showing="<?php echo htmlspecialchars(json_encode($editShowingData)); ?>" class='openEditShowingModalButton py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
                        Edit
                    </button>
                    <button class='openDeleteShowingModalButton bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
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
                    <p id="error-add-showing-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="submit" id="saveAddShowingButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                        <button type="button" id="cancelAddShowingButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>      
            </div>
        </div>
    </div>

    <!-- Edit showing modal -->
    <div id="editShowingModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Edit Showing</h2>
                <form id="editShowingForm" class="text-textLight">
                    <input type="hidden" id="editShowingId" name="editShowingId">
                    <!-- Venue -->
                    <div class="mb-4">
                        <label for="editShowingVenueInput" class="block text-sm font-medium text-textLight">Venue</label>
                        </label>
                        <select id="editShowingVenueInput" name="editShowingVenueInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue</option>
                            <?php foreach ($allVenues as $venue) { ?>
                                <option value="<?php echo htmlspecialchars($venue->getVenueId()); ?>">
                                    <?php echo htmlspecialchars($venue->getName()); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <p id="error-edit-showing-venue" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Date -->
                    <div class="mb-4">
                        <label for="editShowingDateInput" class="block text-sm font-medium text-textLight">Date</label>
                        </label>
                        <input type="date" id="editShowingDateInput" name="editShowingDateInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                        <p id="error-edit-showing-date" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Time -->
                    <div class="mb-4">
                        <label for="editShowingTimeInput" class="block text-sm font-medium text-textLight">Time</label>
                        <select id="editShowingTimeInput" name="editShowingTimeInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue and date first</option>
                        </select>
                        <p id="error-edit-showing-time" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- Room -->
                    <div class="mb-4">
                        <label for="editShowingRoomInput" class="block text-sm font-medium text-textLight">Room</label>
                        <select id="editShowingRoomInput" name="editShowingRoomInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                            <option value="" disabled selected>Select a venue, date, and time first</option>
                        </select>
                        <p id="error-edit-showing-room" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <p id="error-edit-showing-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="submit" id="saveEditShowingButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Save</button>
                        <button type="button" id="cancelEditShowingButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
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

        /*== Add Showing ==*/
        const addShowingModal = document.getElementById('addShowingModal');
        const addShowingForm = document.getElementById('addShowingForm');
        const addShowingButton = document.getElementById('addShowingButton');
        const cancelAddShowingButton = document.getElementById('cancelAddShowingButton');

        const addShowingVenueInput = document.getElementById('addShowingVenueInput');
        const addShowingVenueError = document.getElementById('error-add-showing-venue');
        const addShowingDateInput = document.getElementById('addShowingDateInput');
        const addShowingDateError = document.getElementById('error-add-showing-date');
        const addShowingTimeInput = document.getElementById('addShowingTimeInput');
        const addShowingTimeError = document.getElementById('error-add-showing-time');
        const addShowingRoomInput = document.getElementById('addShowingRoomInput');
        const addShowingRoomError = document.getElementById('error-add-showing-room');
        const addShowingGeneralError = document.getElementById('error-add-showing-general');
        let movieData;

        // Open modal
        addShowingButton.addEventListener('click', () => {
            movieData = addShowingButton.dataset.addShowing;
            movieData = JSON.parse(movieData);

            addShowingModal.classList.remove('hidden');
        });

        // Close modal
        cancelAddShowingButton.addEventListener('click', () => {
            addShowingModal.classList.add('hidden');
            clearValues('add');
        });

        // Submit the add form
		addShowingForm.addEventListener('submit', function(event) {
			event.preventDefault(); // Prevent default form submission
			const xhr = new XMLHttpRequest();
			const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
			xhr.open('POST', `${baseRoute}showing/add`, true);
        

            const addShowingData = {
                action: 'addShowing',
                venueId: addShowingVenueInput.value,
                showingDate: addShowingDateInput.value,
                showingTime: addShowingTimeInput.value.split('-')[0], // Get the start time
                movieId: movieData.movieId,
                roomId: addShowingRoomInput.value
			}

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
				// If the request is done and successful
				if (xhr.readyState === 4 && xhr.status === 200) {
					let response;
					try {
						response = JSON.parse(xhr.response); // Parse the JSON response
					} catch (e) {
						console.error('Could not parse response as JSON:', e);
						return;
					}

					if (response.success) {
						alert('Success! Showing added successfully.');
						window.location.reload();
						clearValues('add');
					} else {
						// Display error messages
                        if (response.errors['showingDate']) {
                            addShowingDateError.textContent = response.errors['showingDate'];
                            addShowingDateError.classList.remove('hidden');
                        }
                        if (response.errors['showingTime']) {
                            addShowingTimeError.textContent = response.errors['showingTime'];
                            addShowingTimeError.classList.remove('hidden');
                        }
                        if (response.errors['general']) {
                            addShowingGeneralError.textContent = response.errors['general'];
                            addShowingGeneralError.classList.remove('hidden');
                        }
						if (response.errorMessage) {
							console.error('Error:', response.errorMessage);
						}
                        else {
							console.error('Error:', response.errors);
						}
					}
				}
			};

			// Send data as URL-encoded string
			const params = Object.keys(addShowingData)
				.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(addShowingData[key])}`)
				.join('&');
			xhr.send(params);
        });

        

        function addFetchRequest(route, data) {
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
                                option.value = `${timeSlot.startTime}-${timeSlot.endTime}`;
                                option.textContent = `${timeSlot.startTime} - ${timeSlot.endTime}`;
                                addShowingTimeInput.appendChild(option);
                            });
                        } 
                        else if (route == "rooms") {
                            addShowingRoomInput.innerHTML = '<option value="" disabled selected>Select a room</option>';
                            response.availableRooms.forEach((room) => {
                                const option = document.createElement('option');
                                option.value = room.roomId;
                                option.textContent = `Room ${room.roomNumber}`;
                                addShowingRoomInput.appendChild(option);
                            });
                        }
                        
                    } else {
                        if (route == "timeslots") {
                            addShowingTimeInput.innerHTML = `<option value="">${response.message}</option>`;
                        }
                        else if (route == "rooms") {
                            addShowingRoomInput.innerHTML = `<option value="">${response.message}</option>`;
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

        function addFetchAvailableTimeslots() {
            const venueId = addShowingVenueInput.value;
            let showingDate = addShowingDateInput.value;

            if (!venueId || !showingDate) {
                return;
            } 

            // Check if the selected date is today or later
            const selectedDate = new Date(showingDate);
            const today = new Date();
            // Reset time components to midnight (start of the day)
            selectedDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                addShowingDateError.textContent = 'Please select a date that is today or a later date.';
                addShowingDateError.classList.remove('hidden');
                return;
            }
            else if (selectedDate >= today) {
                addShowingDateError.textContent = '';
                addShowingDateError.classList.add('hidden');
            }

            const { duration, movieId } = movieData;

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

            addFetchRequest('timeslots', data);
        }

        function addFetchAvailableRooms() {
            const venueId = addShowingVenueInput.value;
            const showingDate = addShowingDateInput.value;
            const showingTime = addShowingTimeInput.value;

            if (!venueId || !showingDate || !showingTime) {
                return;
            }

            const data = {
                venueId: venueId,
                showingDate: showingDate,
                showingTime: showingTime
            };

            addFetchRequest('rooms', data);
        }

        addShowingVenueInput.addEventListener('change', addFetchAvailableTimeslots);
        addShowingDateInput.addEventListener('change', addFetchAvailableTimeslots);
        addShowingTimeInput.addEventListener('change', addFetchAvailableRooms);

        /*== Edit Showing ==*/
        const editShowingModal = document.getElementById('editShowingModal');
        const editShowingForm = document.getElementById('editShowingForm');
        const openEditShowingModalButton = document.querySelectorAll('.openEditShowingModalButton');
        const cancelEditShowingButton = document.getElementById('cancelEditShowingButton');

        const editShowingId = document.getElementById('editShowingId');
        const editShowingVenueInput = document.getElementById('editShowingVenueInput');
        const editShowingVenueError = document.getElementById('error-edit-showing-venue');
        const editShowingDateInput = document.getElementById('editShowingDateInput');
        const editShowingDateError = document.getElementById('error-edit-showing-date');
        const editShowingTimeInput = document.getElementById('editShowingTimeInput');
        const editShowingTimeError = document.getElementById('error-edit-showing-time');
        const editShowingRoomInput = document.getElementById('editShowingRoomInput');
        const editShowingRoomError = document.getElementById('error-edit-showing-room');
        const editShowingGeneralError = document.getElementById('error-edit-showing-general');

        // Open modal
        openEditShowingModalButton.forEach(button => {
            button.addEventListener('click', () => {
                editShowingModal.classList.remove('hidden');
                let editShowingData = button.dataset.editShowing;
                editShowingData = JSON.parse(editShowingData);

                editShowingId.value = editShowingData.showingId;
                editShowingVenueInput.value = editShowingData.venueId;
                editShowingDateInput.value = editShowingData.showingDate;

                movieData = editShowingData.movieData;

                // Convert showing time and duration to start and end time
                const startTime = editShowingData.showingTime.split(':')[0] + ':' + editShowingData.showingTime.split(':')[1];
                const endTime = new Date(new Date(`01/01/2007 ${startTime}`).getTime() + movieData.duration * 60000).toLocaleTimeString('en-GB', {hour: '2-digit', minute: '2-digit'});

                editShowingTimeInput.innerHTML = `<option value="${startTime}-${endTime}" selected>${startTime} - ${endTime}</option>`;

                // Set the room number as selected
                editShowingRoomInput.innerHTML = `<option value="${editShowingData.roomId}" selected>Room ${editShowingData.roomNumber}</option>`;
            });
        });

        // Close modal
        cancelEditShowingButton.addEventListener('click', () => {
            editShowingModal.classList.add('hidden');
            clearValues('edit');
        });

        // Submit the edit form
        editShowingForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
            xhr.open('PUT', `${baseRoute}showing/edit`, true);

            const editShowingData = {
                action: 'editShowing',
                showingId: editShowingId.value,
                venueId: editShowingVenueInput.value,
                showingDate: editShowingDateInput.value,
                showingTime: editShowingTimeInput.value.split('-')[0], // Get the start time
                movieId: movieData.movieId,
                roomId: editShowingRoomInput.value
            }

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                // If the request is done and successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.response); // Parse the JSON response
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }

                    if (response.success) {
                        alert('Success! Showing edited successfully.');
                        window.location.reload();
                        clearValues('edit');
                    } else {
                        // Display error messages
                        if (response.errors['showingDate']) {
                            editShowingDateError.textContent = response.errors['showingDate'];
                            editShowingDateError.classList.remove('hidden');
                        }
                        if (response.errors['showingTime']) {
                            editShowingTimeError.textContent = response.errors['showingTime'];
                            editShowingTimeError.classList.remove('hidden');
                        }
                        if (response.errors['general']) {
                            editShowingGeneralError.textContent = response.errors['general'];
                            editShowingGeneralError.classList.remove('hidden');
                        }
                        if (response.errorMessage) {
                            console.error('Error:', response.errorMessage);
                        } else {
                            console.error('Error:', response.errors);
                        }
                    }
                }
            };

            // Send data as URL-encoded string
            const params = Object.keys(editShowingData)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(editShowingData[key])}`)
                .join('&');
            xhr.send(params);
        });

        function editFetchRequest(route, data) {
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
                            editShowingTimeInput.innerHTML = '<option value="" disabled selected>Select a time slot</option>';
                            response.availableTimes.forEach((timeSlot) => {
                                const option = document.createElement('option');
                                option.value = `${timeSlot.startTime}-${timeSlot.endTime}`;
                                option.textContent = `${timeSlot.startTime} - ${timeSlot.endTime}`;
                                editShowingTimeInput.appendChild(option);
                            });
                        } 
                        else if (route == "rooms") {
                            editShowingRoomInput.innerHTML = '<option value="" disabled selected>Select a room</option>';
                            response.availableRooms.forEach((room) => {
                                const option = document.createElement('option');
                                option.value = room.roomId;
                                option.textContent = `Room ${room.roomNumber}`;
                                editShowingRoomInput.appendChild(option);
                            });
                        }
                        
                    } else {
                        if (route == "timeslots") {
                            editShowingTimeInput.innerHTML = `<option value="">${response.message}</option>`;
                        }
                        else if (route == "rooms") {
                            editShowingRoomInput.innerHTML = `<option value="">${response.message}</option>`;
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

        function editFetchAvailableTimeslots() {
            const venueId = editShowingVenueInput.value;
            let showingDate = editShowingDateInput.value;

            if (!venueId || !showingDate) {
                return;
            } 

            // Check if the selected date is today or later
            const selectedDate = new Date(showingDate);
            const today = new Date();
            // Reset time components to midnight (start of the day)
            selectedDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                editShowingDateError.textContent = 'Please select a date that is today or a later date.';
                editShowingDateError.classList.remove('hidden');
                return;
            }
            else if (selectedDate >= today) {
                editShowingDateError.textContent = '';
                editShowingDateError.classList.add('hidden');
            }

            const { duration, movieId } = movieData;

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

            editFetchRequest('timeslots', data);
        }

        function editFetchAvailableRooms() {
            const venueId = editShowingVenueInput.value;
            const showingDate = editShowingDateInput.value;
            const showingTime = editShowingTimeInput.value;

            if (!venueId || !showingDate || !showingTime) {
                return;
            }

            const data = {
                venueId: venueId,
                showingDate: showingDate,
                showingTime: showingTime
            };

            editFetchRequest('rooms', data);
        }

        editShowingVenueInput.addEventListener('change', editFetchAvailableTimeslots);
        editShowingDateInput.addEventListener('change', editFetchAvailableTimeslots);
        editShowingTimeInput.addEventListener('change', editFetchAvailableRooms);

        // Clear error messages and input values
        function clearValues(action) {
            if (action === 'edit') {
                editShowingVenueError.classList.add('hidden');
                editShowingDateError.classList.add('hidden');
                editShowingTimeError.classList.add('hidden');
                editShowingRoomError.classList.add('hidden');
                editShowingGeneralError.classList.add('hidden');
                editShowingForm.reset();
            }
            else if (action === 'add') {
                addShowingVenueError.classList.add('hidden');
                addShowingDateError.classList.add('hidden');
                addShowingTimeError.classList.add('hidden');
                addShowingRoomError.classList.add('hidden');
                addShowingGeneralError.classList.add('hidden');
                addShowingForm.reset();
            }
        }
    });
</script>
