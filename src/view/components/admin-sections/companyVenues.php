<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Company & Venues</h2>
    <div class="flex flex-col">
        <hr class="mb-4 w-full mx-auto border-gray-300">
        
        <!-- Venue details container -->
        <div id="venueDetails" class="flex flex-col items-start hidden my-8">
                <div class="grid grid-cols-2 w-1/4">
                    <label for="venueName" class="text-white">Venue Name:</label>
                    <input type="text" id="venueName" class="text-black mb-4 rounded-sm" readonly>
                </div>
                <div class="grid grid-cols-2 w-1/4">
                    <label for="venuePhone" class="text-white">Phone Number:</label>
                    <input type="text" id="venuePhone" class="text-black w-full mb-4 rounded-sm" readonly>
                </div>
                <div class="grid grid-cols-2 w-1/4">
                    <label for="venueEmail" class="text-white">Contact Email:</label>
                    <input type="email" id="venueEmail" class="text-black w-full mb-4 rounded-sm" readonly>
                </div>
                <div class="grid grid-cols-2 w-1/4">
                    <label for="venueAddress" class="text-white">Address:</label>
                    <input type="text" id="venueAddress" class="text-black w-full mb-4 rounded-sm" readonly>
                </div>
        </div>

        <div class="grid grid-cols-5 gap-6 w-full px-4">
            <?php
            $venueController = new VenueController();
            $allVenues = $venueController->getAllVenues();

            if (isset($allVenues['errorMessage'])) {
                echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allVenues['errorMessage']) . "</p>";
            } else {
                foreach ($allVenues as $venue) {
                    echo "<button class='venueCard bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 cursor-pointer' 
                    data-venue-name='" . htmlspecialchars($venue->getName()) . "' data-venue-phone='" . htmlspecialchars($venue->getPhoneNr()) . 
                    "' data-venue-email='" . htmlspecialchars($venue->getContactEmail()) . "' data-venue-address='" . htmlspecialchars($venue->getAddress()->getStreet()) 
                    . "'>";
                    echo "<p class='text-center font-medium text-gray-700'>" . htmlspecialchars($venue->getName()) . "</p>";
                    echo "</button>";
                }
            }
            ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const venueDetails = document.getElementById('venueDetails');
    const venueName = document.getElementById('venueName');
    const venuePhone = document.getElementById('venuePhone');
    const venueEmail = document.getElementById('venueEmail');
    const venueAddress = document.getElementById('venueAddress');

    document.querySelectorAll('.venueCard').forEach(card => {
        card.addEventListener('click', () => {
            // Update venue details
            venueName.value = card.dataset.venueName;
            venuePhone.value = card.dataset.venuePhone;
            venueEmail.value = card.dataset.venueEmail;
            venueAddress.value = card.dataset.venueAddress;
            
            // Display the details container
            venueDetails.classList.remove('hidden');
        });
    });
});
</script>

