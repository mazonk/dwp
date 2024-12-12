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
            <div class="grid grid-cols-4 gap-6">
                <?php foreach ($showings as $showing) { ?>
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo $showing['showingDate']; ?> at <?php echo $showing['showingTime']; ?></h3>
                        <p class="text-gray-600">Room: <?php echo $showing['roomNumber']; ?></p>
                        <p class="text-gray-600">Bookings: <?php echo $showing['bookings']; ?></p>
                        <p class="text-gray-600">Tickets: <?php echo $showing['tickets']; ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
