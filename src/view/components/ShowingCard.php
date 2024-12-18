<?php
include_once "src/model/entity/Showing.php";

class ShowingCard {
    public static function render(Showing $showing) {
        $movie = $showing->getMovie();

        if ($movie) {
            ?>
            <form action="<?php echo $_SESSION['baseRoute'] ?>booking" method="GET">
                <input type="hidden" name="showing" value="<?php echo $showing->getShowingId(); ?>">
                <button type="submit" name="" class="w-[6rem] h-[2.5rem] flex items-center justify-center rounded-[0.375rem] text-center m-[0.625rem] bg-pink-950 ease-in-out duration-300 hover:bg-lime-600 text-white">
                    <?php echo $showing->getShowingTime()->format('H:i'); ?>
                </button>
            </form>
            <?php
        } else {
            echo "<div class='text-red-500'>No associated movie found.</div>";
        }
    }
}