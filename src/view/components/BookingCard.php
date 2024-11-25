<?php
include_once "src/model/entity/Ticket.php";

class BookingCard {

    public static function render(array $tickets, Venue $venue) {
        $totalPrice = 0;
        foreach ($tickets as $ticket) {
            $totalPrice += $ticket->getTicketType()->getPrice();
        }
        $ticketCount = count($tickets);
        ?>
        <div class="w-[12.5rem] text-center m-[0.625rem] booking-card bg-bgSemiDark rounded-lg shadow-lg p-4 border border-borderDark">
            <!-- Movie Title and Ticket Count -->
            <div class="flex items-center justify-start mb-2">
                <div class="text-[1.125rem] text-primary font-semibold">
                    <?php echo htmlspecialchars($tickets[0]->getShowing()->getMovie()->getTitle()); ?>
                </div>
                <?php if ($ticketCount > 1): ?>
                    <div class="ml-2 bg-primary text-left text-textDark text-[0.75rem] font-semibold rounded-full px-2 py-[0.125rem]">
                        <?php echo 'x' . $ticketCount; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Showing Date -->
            <div class="text-[0.875rem] text-left text-textNormal mb-2">
                <?php echo htmlspecialchars($tickets[0]->getShowing()->getShowingDate()->format('Y-m-d')); ?>
            </div>
            
            <!-- Venue and Total Price -->
            <div class="flex flex-col space-y-2 text-[1rem] text-textLight">
                <div class="flex items-center justify-start space-x-2 text-left">
                    <i class="ri-map-pin-line text-primary"></i>
                    <span><?php echo htmlspecialchars($venue->getName()); ?></span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="ri-money-dollar-circle-line text-primary"></i>
                    <span><?php echo htmlspecialchars($totalPrice) . ' $'; ?></span>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
