<?php
include_once "src/controller/ShowingController.php";
include_once "src/controller/MovieController.php";
include_once "src/view/components/admin-sections/showings/ShowingCardAdmin.php";

$movieController = new MovieController();
$movies = $movieController->getAllMovies();

$showingController = new ShowingController();
?>

<div>
    <!-- Movie List Section -->
    <div class="flex flex-wrap my-[2rem]">
        <?php foreach ($movies as $movie): ?>
            <div class="w-full p-4 border rounded shadow hover:shadow-lg transition mb-6">
                <div class="flex justify-between items-center">
                    <!-- Movie Title aligned left -->
                    <h4 class="text-lg font-bold"><?php echo htmlspecialchars($movie->getTitle()); ?></h4>

                    <!-- Add Showing button aligned right -->
                    <button id="addMovieButton" class="bg-primary text-textDark font-bold py-2 px-4 rounded hover:bg-primaryHover">
                        Add Showing
                    </button>
                </div>
                <!-- Fetch and display showings for the current movie -->
                <?php
                $showings = $showingController->getAllShowingsForMovie($movie->getMovieId());
                if (isset($showings['errorMessage'])) {
                    echo $showings['errorMessage']; // Handle error if any
                } else {
                    // Group showings by date and filter out past ones
                    $groupedShowings = [];
                    $today = new DateTime(); // Get current date and time

                    foreach ($showings as $showing) {
                        $showingDate = $showing->getShowingDate();
                        // Only add showings from today and the future
                        if ($showingDate >= $today) {
                            $formattedDate = $showingDate->format('Y-m-d'); // format date to group by
                            $groupedShowings[$formattedDate][] = $showing;
                        }
                    }

                    // Sort the dates in ascending order
                    ksort($groupedShowings);

                    // Calculate the maximum number of days to display (limit to 6 days)
                    $groupedShowings = array_slice($groupedShowings, 0, 6);

                    // Initialize columns for each day (empty columns if no showings for a day)
                    $columns = array_fill(0, count($groupedShowings), []);

                    // Add showings to the columns based on their day
                    $i = 0;
                    foreach ($groupedShowings as $date => $dateShowings) {
                        // Sort showings by time (assuming `getShowingTime()` method is available)
                        usort($dateShowings, function ($a, $b) {
                            return $a->getShowingDate() <=> $b->getShowingDate();
                        });
                        $columns[$i] = $dateShowings;
                        $i++;
                    }
                }
                ?>
                <!-- Display Showings in columns -->
                <div class="flex gap-4 overflow-x-auto" style="max-width: 100%; scroll-snap-type: x mandatory;">
                    <?php
                    // Iterate over columns and display showings for each day
                    foreach ($columns as $index => $column) {
                        // Format the date
                        $formattedDate = (new DateTime(array_keys($groupedShowings)[$index]))->format('l, d M Y');
                        echo '<div class="flex-none p-4 w-[calc(100%/6)] scroll-snap-align:start">';
                        echo '<div class="text-center font-semibold mb-2">' . $formattedDate . '</div>';

                        if (empty($column)) {
                            // If no showings for this date, display a message
                            echo '<div class="text-center text-gray-500">No showings for this movie on this date.</div>';
                        } else {
                            echo '<div class="space-y-2">';
                            // Render showings for the specific date
                            foreach ($column as $showing) {
                                ShowingCardAdmin::render($showing);
                            }
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Scroll Buttons -->
                <div class="flex justify-center mt-4">
                    <button id="scrollLeft" class="px-4 py-2 bg-primary text-textDark font-bold rounded hover:bg-primaryHover">←</button>
                    <button id="scrollRight" class="px-4 py-2 bg-primary text-textDark font-bold rounded hover:bg-primaryHover ml-2">→</button>
                </div>

                <script>
                    // Scroll functionality for left and right buttons
                    document.getElementById('scrollLeft').addEventListener('click', function() {
                        document.querySelector('.flex').scrollBy({
                            left: -300, // Adjust the scroll amount
                            behavior: 'smooth'
                        });
                    });

                    document.getElementById('scrollRight').addEventListener('click', function() {
                        document.querySelector('.flex').scrollBy({
                            left: 300, // Adjust the scroll amount
                            behavior: 'smooth'
                        });
                    });
                </script>
            </div>
        <?php endforeach; ?>
    </div>
</div>
