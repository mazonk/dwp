<?php parse_str(file_get_contents("php://input"), $_PUT); ?>
<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Content Management</h2>
    <div class="flex flex-col">
        <hr class="mb-4 w-full mx-auto border-gray-300">
        <?php
        require_once "src/controller/VenueController.php";
        $venueController = new VenueController();
        $allVenues = $venueController->getAllVenues();
        ?>
        <div class="grid grid-cols-<?php echo count($allVenues) > 5 ? '5' : count($allVenues) ?> gap-6 w-full px-4">
        <?php

        if (isset($allVenues['errorMessage'])) {
            echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allVenues['errorMessage']) . "</p>";
        } else {
            foreach ($allVenues as $venue) {
                $venueData = json_encode([
                    'id' => $venue->getVenueId(),
                    'name' => $venue->getName(),
                    'phone' => $venue->getPhoneNr(),
                    'email' => $venue->getContactEmail(),
                    'address' => [
                        'addressId' => $venue->getAddress()->getAddressId(),
                        'street' => $venue->getAddress()->getStreet(),
                        'streetNr' => $venue->getAddress()->getStreetNr(),
                        'postalCode' => [
                            'postalCodeId' => $venue->getAddress()->getPostalCode()->getPostalCodeId(),
                            'postalCode' => $venue->getAddress()->getPostalCode()->getPostalCode(),
                            'city' => $venue->getAddress()->getPostalCode()->getCity()
                        ]
                    ],
                ]);
                echo "<button class='venueCard bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 cursor-pointer' 
                        data-venue='" . htmlspecialchars($venueData) . "'>";
                echo "<p class='text-center font-medium text-gray-700'>" . htmlspecialchars($venue->getName()) . "</p>";
                echo "</button>";
            }
        }
        ?>
        </div>
    </div>
</section>