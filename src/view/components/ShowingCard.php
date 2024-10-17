<?php
include_once "src/model/entity/Showing.php";

class ShowingCard {
    public static function render(Showing $showing) {
        ?>
        <div class="w-[5rem] h-[2rem] rounded-[0.625rem] text-center m-[0.625rem] bg-green-500 text-white">
            <?php echo $showing->getShowingTime()->format('H:i');?>
        </div>
        <?php
    }
}