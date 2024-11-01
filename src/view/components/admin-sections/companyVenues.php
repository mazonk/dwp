<?php 
parse_str(file_get_contents("php://input"), $_PUT);
?>
<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Company & Venues</h2>
    <div class="flex flex-col">
        <hr class="mb-4 w-full mx-auto border-gray-300">
        
        <!-- Venue details container -->
        <div id="venueDetails" class="flex flex-col items-start hidden my-8">
            <div class="grid grid-cols-2 w-full gap-4">
                <div class="grid grid-cols-1">
                    <div class="grid grid-cols-2">
                        <label for="venueId" class="text-white">Venue ID:</label>
                        <input type="text" id="venueId" class="text-black mb-4 rounded-sm" readonly>
                        <input type="hidden" id="addressId">
                        <input type="hidden" id="postalCodeId">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venueName" class="text-white">Venue Name:</label>
                        <input type="text" id="venueName" class="text-black mb-4 rounded-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venuePhone" class="text-white">Phone Number:</label>
                        <input type="text" id="venuePhone" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venueEmail" class="text-white">Contact Email:</label>
                        <input type="email" id="venueEmail" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                </div>
                
                <div class="grid grid-cols-1">
                    <div class="grid grid-cols-2">
                        <label for="venueStreet" class="text-white">Street:</label>
                        <input type="text" id="venueStreet" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venueStreetNr" class="text-white">Street Number:</label>
                        <input type="text" id="venueStreetNr" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venuePostalCode" class="text-white">Postal Code:</label>
                        <input type="text" id="venuePostalCode" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="venueCity" class="text-white">City:</label>
                        <input type="text" id="venueCity" class="text-black w-full mb-4 rounded-sm" readonly>
                    </div>
                </div>
            </div>

            <button id="editButton" class="mt-4 bg-blue-500 text-white rounded-md px-4 py-2">Edit</button>
        </div>


        <div class="grid grid-cols-5 gap-6 w-full px-4">
            <?php
            require_once "src/controller/VenueController.php";
            $venueController = new VenueController();
            $allVenues = $venueController->getAllVenues();

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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const venueDetails = document.getElementById('venueDetails');
    const venueId = document.getElementById('venueId');
    const addressId = document.getElementById('addressId');
    const postalCodeId = document.getElementById('postalCodeId');
    const venueName = document.getElementById('venueName');
    const venuePhone = document.getElementById('venuePhone');
    const venueEmail = document.getElementById('venueEmail');
    const venueStreet = document.getElementById('venueStreet');
    const venueStreetNr = document.getElementById('venueStreetNr');
    const venuePostalCode = document.getElementById('venuePostalCode');
    const venueCity = document.getElementById('venueCity');
    const editButton = document.getElementById('editButton');

    // Event listeners for all venue cards
    document.querySelectorAll('.venueCard').forEach(card => {
        card.addEventListener('click', () => {
            // Parse the venue data from the card's data attribute
            const venue = JSON.parse(card.dataset.venue);
            
            // Update the input fields with the venue data
            venueId.value = venue.id;
            addressId.value = venue.address.addressId;
            postalCodeId.value = venue.address.postalCode.postalCodeId;
            venueName.value = venue.name;
            venuePhone.value = venue.phone;
            venueEmail.value = venue.email;
            venueStreet.value = venue.address.street;
            venueStreetNr.value = venue.address.streetNr;
            venuePostalCode.value = venue.address.postalCode.postalCode;
            venueCity.value = venue.address.postalCode.city;
            
            // Show the venue details section
            venueDetails.classList.remove('hidden');
        });
    });

    // Event listener for the edit/save button
    editButton.addEventListener('click', () => {
        const isReadOnly = venueName.readOnly;

        // Toggle read-only state for input fields
        venueName.readOnly = !isReadOnly;
        venuePhone.readOnly = !isReadOnly;
        venueEmail.readOnly = !isReadOnly;
        venueStreet.readOnly = !isReadOnly;
        venueStreetNr.readOnly = !isReadOnly;
        venuePostalCode.readOnly = !isReadOnly;
        venueCity.readOnly = !isReadOnly;

        // Change button text and styling based on the state
        editButton.textContent = isReadOnly ? 'Save' : 'Edit';
        editButton.classList.toggle('bg-blue-500', !isReadOnly);
        editButton.classList.toggle('bg-green-500', isReadOnly);

        // Handle save action if not in read-only mode
        if (!isReadOnly) {
            const updatedVenue = {
                id: venueId.value,
                name: venueName.value,
                phone: venuePhone.value,
                email: venueEmail.value,
                street: venueStreet.value,
                streetNr: venueStreetNr.value,
                postalCode: venuePostalCode.value,
                city: venueCity.value,
                addressId: addressId.value,
                postalCodeId: postalCodeId.value 
            };

            const xhr = new XMLHttpRequest();
            xhr.open('PUT', '/dwp/venue/edit', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Optionally handle the response here
                    console.log(xhr.response);
                    // window.location.reload(); // Reload the page to see updated details
                }
            };
            xhr.send(`action=editVenue&venueId=${encodeURIComponent(updatedVenue.id)}&name=${encodeURIComponent(updatedVenue.name)}&phoneNr=${encodeURIComponent(updatedVenue.phone)}
            &email=${encodeURIComponent(updatedVenue.email)}&street=${encodeURIComponent(updatedVenue.street)}&streetNr=${encodeURIComponent(updatedVenue.streetNr)}
            &postalCode=${encodeURIComponent(updatedVenue.postalCode)}&city=${encodeURIComponent(updatedVenue.city)}&addressId=${encodeURIComponent(updatedVenue.addressId)}
            &postalCodeId=${encodeURIComponent(updatedVenue.postalCodeId)}`);
        }
    });
});
</script>


