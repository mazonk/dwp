<?php
include_once "src/view/components/admin-sections/openingHours/OpeningHoursCard.php";
?>

<div>
  <div class="flex justify-between my-[2rem]">
      <h3 class="text-[1.5rem] font-semibold">
				Opening Hours
				<span id="selectedVenue" class="ml-[1rem] text-lg text-primary italic font-medium px-4 py-1 rounded-full bg-primary/15 hidden"></span>
			</h3>
      <div class="flex gap-[.5rem]">
				<button id="addOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover hidden">
						Add New
				</button>
				<button id="closeOpeningHourCardsButton" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 hidden">
					Close
				</button>
			</div>
  </div>
	<?php
	require_once "src/controller/VenueController.php";
	$venueController = new VenueController();
	$allVenues = $venueController->getAllVenues();
	?>
	<div id="venueCardsContainer" class="grid grid-cols-<?php echo count($allVenues) > 5 ? '5' : count($allVenues) ?> gap-6 w-full">
		<?php
		if (isset($allVenues['errorMessage'])) {
				echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allVenues['errorMessage']) . "</p>";
		} else {
				foreach ($allVenues as $venue) {
						$venueData = json_encode([
								'id' => $venue->getVenueId(),
								'name' => $venue->getName(),
						]);
						echo "
						<button class='venueCard bg-bgSemiDark p-6 border-[1px] border-borderDark rounded-lg cursor-pointer duration-[.2s] ease-in-out hover:scale-[1.025] hover:border-borderLight' data-venue='" . htmlspecialchars($venueData) . "'>
							<p class='text-center font-medium text-white'>" . htmlspecialchars($venue->getName()) . "</p>
						</button>
						";
				}
			}
			?>
	</div>

	<!-- Display opening hours for a selected venue in cards -->
	<?php
	require_once "src/controller/OpeningHourController.php";
	$openingHourController = new OpeningHourController();
	$openingHours = $openingHourController->getOpeningHoursById(3);
	?>
	<div id="openingHourCardsContainer" class="grid grid-cols-5 gap-4 hidden">
		<?php
		if (isset($openingHours['errorMessage'])) {
			echo $openingHours['errorMessage'];
		} else {
			foreach ($openingHours as $openingHour) {
				OpeningHoursCard::render($openingHour);
			}
		}
		?>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const openingHourCardsContainer = document.getElementById('openingHourCardsContainer');
		const venueCardsContainer = document.getElementById('venueCardsContainer');
		const selectedVenue = document.getElementById('selectedVenue');
		const addOpeningHourButton = document.getElementById('addOpeningHourButton');
		const closeOpeningHourCardsButton = document.getElementById('closeOpeningHourCardsButton');

		// Add click event listener to each venue card
		document.querySelectorAll('.venueCard').forEach(card => {
			// Fetch opening hours for the selected venue
			card.addEventListener('click', () => {
				const xhr = new XMLHttpRequest();
				const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
				xhr.open('POST', `${baseRoute}openingHours/getById`, true);

				// Parse the venue data from the card's data attribute
				const data = JSON.parse(card.getAttribute('data-venue'));
				const venueData = {
            action: 'getOpeningHoursById',
            venueId: data.id
        };

				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
					// If the request is done and successful
					if (xhr.readyState === 4 && xhr.status === 200) {
							let response;
							try {
									response = JSON.parse(xhr.response);
							} catch (e) {
									console.error('Could not parse response as JSON:', e);
									return;
							}
							console.log('Response from server:', response); // Log the response

						if (!response.error) {
							alert('Opening hours fetched successfully');
							console.log('Opening hours fetched successfully:', response.openingHours);
							displayOpeningHourCards(data.name); // Display opening hour cards
						}
						else {
							alert('Failed to fetch opening hours');
							console.error('Error:', response.errors);
						}
						
					}
				};

				// Send data as URL-encoded string
        const params = Object.keys(venueData)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(venueData[key])}`)
            .join('&');
        xhr.send(params);
			});
		});

		// Dipslay opening hour cards for the selected venue
		function displayOpeningHourCards(venueName) {
			openingHourCardsContainer.classList.remove('hidden');
			venueCardsContainer.classList.add('hidden');

			selectedVenue.textContent = venueName;
			selectedVenue.classList.remove('hidden');

			addOpeningHourButton.classList.remove('hidden');
			closeOpeningHourCardsButton.classList.remove('hidden');
		}

		// Close opening hour cards and show venue cards
		function closeOpeningHourCards() {
			openingHourCardsContainer.classList.add('hidden');
			venueCardsContainer.classList.remove('hidden');

			selectedVenue.textContent = '';
			selectedVenue.classList.add('hidden');

			addOpeningHourButton.classList.add('hidden');
			closeOpeningHourCardsButton.classList.add('hidden');
		}

		// Add click event listener to close opening hour cards button
		closeOpeningHourCardsButton.addEventListener('click', closeOpeningHourCards);

		/*== Add News ==*/
	});
</script>