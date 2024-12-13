<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Bookings & Invoices</h2>
    <?php
    if (isset($_GET['selectedMovie']) && !isset($_GET['selectedShowing'])) {
        require_once "src/view/components/admin-sections/movies/movieShowings.php";
    } else if (isset($_GET['selectedMovie']) && isset($_GET['selectedShowing'])) {
        require_once "src/view/components/admin-sections/bookings/showingBookings.php";
    }
    else {
        require_once 'src/view/components/admin-sections/movies/moviesWithShowings.php';
    }
    ?>
</section>