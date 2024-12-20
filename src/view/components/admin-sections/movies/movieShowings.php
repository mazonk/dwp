<?php
require_once "src/controller/MovieController.php";
require_once "src/controller/ShowingController.php";
require_once "src/controller/VenueController.php";

if (isset($_GET['selectedMovie']) && is_numeric($_GET['selectedMovie'])) {
    $movieId = intval($_GET['selectedMovie']);
    $showingController = new ShowingController();
    $movieController = new MovieController();
    $venueController = new VenueController();
    $allVenues = $venueController->getAllVenues();
    $movie = $movieController->getMovieById($movieId);
    $showings = $showingController->getShowingsForMovieAdmin($movieId);
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
?>

<div class="p-6 min-h-screen">
    <div class="w-full">
        <a href="?section=bookings-invoices" class="text-blue-500 underline mb-4 block"><-Back to Movies</a>
        <h1 class="text-2xl font-bold mb-4">Showings for <?php echo htmlspecialchars($movie->getTitle()); ?>:</h1>

        <?php if (isset($showings['errorMessage'])) { ?>
            <div class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md">
                <?php echo htmlspecialchars($showings['errorMessage']); ?>
            </div>
        <?php } else { ?>

        <!-- Filters -->
        <div class="flex flex-row space-x-12 align-baseline">
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
                <button id="clearFilterButton" class="ml-2 bg-red-500 font-bold text-gray-100 p-2 rounded-md shadow-sm">Clear date</button>
            </div>
        </div>

        <div id="showingsList" class="grid grid-cols-4 gap-6">
            <?php foreach ($showings as $showing) { ?>
                <a 
                    href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>&selectedShowing=<?php echo $showing['showingId']; ?>" 
                    class="bg-bgSemiDark p-4 rounded-lg shadow-md border border-borderDark showing-item cursor-pointer" 
                    data-date="<?php echo htmlspecialchars($showing['showingDate']); ?>" 
                    data-venue="<?php echo htmlspecialchars($showing['venueId']); ?>">
                    <h3 class="text-lg font-semibold text-white mb-2">
                        <?php echo $showing['showingDate']; ?> at <?php echo $showing['showingTime']; ?>
                    </h3>
                    <p class="text-gray-400">Room: <?php echo $showing['roomNumber']; ?></p>
                    <p class="text-gray-400">Bookings: <?php echo $showing['bookings']; ?></p>
                    <p class="text-gray-400">Tickets: <?php echo $showing['tickets']; ?></p>
                </a>

            <?php } ?>
        </div>

        <div id="noShowingsMessage" class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md hidden">
            No showings available for the selected filters. Please clear the filter, or select different options.
        </div>
        <?php } ?>
    </div>
</div>

<script>
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
</script>
