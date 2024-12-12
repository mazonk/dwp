<?php
include_once "src/controller/MovieController.php";
include_once "src/controller/ShowingController.php";

if (isset($_GET['selectedMovie']) && is_numeric($_GET['selectedMovie'])) {
    $movieId = intval($_GET['selectedMovie']);
    $showingController = new ShowingController();
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
        <h1 class="text-2xl font-bold mb-4">Showings for Selected Movie</h1>

        <?php if (isset($showings['errorMessage'])) { ?>
            <div class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md">
                <?php echo htmlspecialchars($showings['errorMessage']); ?>
            </div>
        <?php } else { ?>

        <!-- Date Filter Dropdown -->
        <div class="mb-6">
            <label for="dateFilter" class="block font-medium mb-2">Filter by Date:</label>
            <input id="dateFilter" type="date" class="bg-white text-black border border-gray-300 p-2 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
            <button id="clearFilterButton" class="ml-2 bg-gray-200 text-gray-700 p-2 rounded-md shadow-sm">Clear Filter</button>
        </div>

        <div id="showingsList" class="grid grid-cols-4 gap-6">
            <?php foreach ($showings as $showing) { ?>
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 showing-item" data-date="<?php echo htmlspecialchars($showing['showingDate']); ?>">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo $showing['showingDate']; ?> at <?php echo $showing['showingTime']; ?></h3>
                    <p class="text-gray-600">Room: <?php echo $showing['roomNumber']; ?></p>
                    <p class="text-gray-600">Bookings: <?php echo $showing['bookings']; ?></p>
                    <p class="text-gray-600">Tickets: <?php echo $showing['tickets']; ?></p>
                </div>
            <?php } ?>
        </div>

        <div id="noShowingsMessage" class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md hidden">No showings available for the selected date. Please clear the filter, or select another date.</div>
        <?php } ?>
    </div>
</div>

<script>
    const dateFilter = document.getElementById('dateFilter');
    const clearFilterButton = document.getElementById('clearFilterButton');
    const noShowingsMessage = document.getElementById('noShowingsMessage');
    const showings = document.querySelectorAll('.showing-item');

    dateFilter.addEventListener('change', function () {
        const selectedDate = this.value;
        let hasVisibleShowings = false;

        showings.forEach(showing => {
            if (!selectedDate || showing.dataset.date === selectedDate) {
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
    });

    clearFilterButton.addEventListener('click', function () {
        dateFilter.value = '';
        showings.forEach(showing => {
            showing.style.display = "block";
        });
        noShowingsMessage.classList.add('hidden');
    });
</script>
