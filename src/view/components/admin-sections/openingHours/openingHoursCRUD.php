<?php
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
	<!-- Display all venues in cards -->
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
	<div id="openingHoursCardsContainer" class="grid grid-cols-5 gap-4 hidden"></div>

	<!-- Add Opening Hours Form Modal -->
	<div id="addOpeningHoursModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
			<div class="flex items-center justify-center min-h-screen">
					<!-- Modal -->
					<div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
							<h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Opening Hour</h2>
							<form id="addOpeningHoursForm" class="text-textLight">
									<div class="mb-4">
											<label for="addDayInput" class="block text-sm font-medium text-text-textLight">Day</label>
											<select id="addDayInput" name="addDayInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<option value="" disabled selected>Select a day</option>
													<option value="Monday">Monday</option>
													<option value="Tuesday">Tuesday</option>
													<option value="Wednesday">Wednesday</option>
													<option value="Thursday">Thursday</option>
													<option value="Friday">Friday</option>
													<option value="Saturday">Saturday</option>
													<option value="Sunday">Sunday</option>
											</select>
											<p id="error-add-day"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex gap-[1rem]">
											<div class="w-full mb-4">
													<label for="addOpeningTimeInput" class="block text-sm font-medium text-text-textLight">Opening Time</label>
													<input id="addOpeningTimeInput" name="addOpeningTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-add-openingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
											<div class="w-full mb-4">
													<label for="addClosingTimeInput" class="block text-sm font-medium text-text-textLight">Closing Time</label>
													<input id="addClosingTimeInput" name="addClosingTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-add-closingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
									</div>
									<!-- Is current -->
									<div class="mb-4">
											<label for="addIsCurrentInput" class="block text-sm font-medium text-text-textLight">Current</label>
											<select id="addIsCurrentInput" name="addIsCurrentInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<option value="" disabled selected>Select an option</option>
													<option value="1">Yes</option>
													<option value="0">No</option>
											</select>
											<p id="error-add-isCurrent" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex justify-end">
											<button type="submit" id="saveAddOpeningHoursButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
											<button type="button" id="cancelAddOpeningHoursButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
									</div>
							</form>
					</div>
			</div>
  </div>

	<!-- Edit Opening Hours Form Modal -->
	<div id="editOpeningHoursModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
			<div class="flex items-center justify-center min-h-screen">
					<!-- Modal -->
					<div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
							<h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Opening Hour</h2>
							<form id="editOpeningHoursForm" class="text-textLight">
									<input type="hidden" id="editOpeningHoursId" name="editOpeningHoursId">
									<div class="mb-4">
											<label for="editDayInput" class="block text-sm font-medium text-text-textLight">Day</label>
											<select id="editDayInput" name="editDayInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<option value="" disabled>Select a day</option>
													<option value="Monday">Monday</option>
													<option value="Tuesday">Tuesday</option>
													<option value="Wednesday">Wednesday</option>
													<option value="Thursday">Thursday</option>
													<option value="Friday">Friday</option>
													<option value="Saturday">Saturday</option>
													<option value="Sunday">Sunday</option>
											</select>
											<p id="error-edit-day"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex gap-[1rem]">
											<div class="w-full mb-4">
													<label for="editOpeningTimeInput" class="block text-sm font-medium text-text-textLight">Opening Time</label>
													<input id="editOpeningTimeInput" name="editOpeningTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-edit-openingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
											<div class="w-full mb-4">
													<label for="editClosingTimeInput" class="block text-sm font-medium text-text-textLight">Closing Time</label>
													<input id="editClosingTimeInput" name="editClosingTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-edit-closingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
									</div>
									<!-- Is current -->
									<div class="mb-4">
											<label for="editIsCurrentInput" class="block text-sm font-medium text-text-textLight">Current</label>
											<select id="editIsCurrentInput" name="editIsCurrentInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<option value="" disabled>Select an option</option>
													<option value="1">Yes</option>
													<option value="0">No</option>
											</select>
											<p id="error-edit-isCurrent" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex justify-end">
											<button type="submit" id="saveEditOpeningHoursButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
											<button type="button" id="cancelEditOpeningHoursButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
									</div>
							</form>
					</div>
			</div>
  </div>


</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const openingHoursCardsContainer = document.getElementById('openingHoursCardsContainer');
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

				// Parse the venue data from the card's data attribute
				const data = JSON.parse(card.getAttribute('data-venue'));
				const venueData = {
						action: 'getOpeningHoursById',
						venueId: data.id
				};

				// Convert venueData to query string
				const params = Object.keys(venueData)
						.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(venueData[key])}`)
						.join('&');

				// Add params to the GET request URL
				xhr.open('GET', `${baseRoute}openingHours/getById?${params}`, true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						let response;
						try {
								response = JSON.parse(xhr.response);
						} catch (e) {
								console.error('Could not parse response as JSON:', e);
								return;
						}

						if (!response.error) {
								displayOpeningHourCards(data.name, response.openingHours); // Display opening hour cards
						} else {
								console.error('Error:', response.errors);
						}
					}
				};
    		xhr.send();
			});
		});

		// Dipslay opening hour cards for the selected venue
		function displayOpeningHourCards(venueName, openingHours) {
			openingHoursCardsContainer.classList.remove('hidden');
			venueCardsContainer.classList.add('hidden');

			selectedVenue.textContent = venueName;
			selectedVenue.classList.remove('hidden');

			addOpeningHourButton.classList.remove('hidden');
			closeOpeningHourCardsButton.classList.remove('hidden');

			openingHoursCardsContainer.innerHTML = '';
			if (openingHours.length === 0) {
				openingHoursCardsContainer.innerHTML = "<p class='text-gray-400 italic'>No opening hours available</p>";
				return;
			}
			else {
				openingHours.forEach(openingHour => {
					openingHoursCardsContainer.innerHTML += `
						<div class='bg-bgSemiDark border-[1px] border-borderDark rounded p-4'>
							<div class='flex justify-between items-center'>
								<h4 class='text-[1.25rem] font-semibold'>${openingHour.day}</h4>
								${openingHour.isCurrent ? "<p class='py-[.125rem] px-2 text-[.75rem] font-medium text-primary border-[1px] border-primary rounded-full'>Current</p>" : ''}
							</div>
							<p>${openingHour.openingTime} - ${openingHour.closingTime}</p>
							<div class='flex justify-start mt-4 gap-[.5rem]'>
								<button onclick="openEditOpeningHoursModal('${openingHour.id}')" class='py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
									Edit
								</button>
								<button onclick="openDeleteOpeningHoursModal('${openingHour.id}')" class='bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
									Delete
								</button>
							</div>
						</div>
					`;
				});
				return;
			}
		}

		// Close opening hour cards and show venue cards
		closeOpeningHourCardsButton.addEventListener('click', () => {
			openingHoursCardsContainer.classList.add('hidden');
			venueCardsContainer.classList.remove('hidden');

			selectedVenue.textContent = '';
			selectedVenue.classList.add('hidden');

			addOpeningHourButton.classList.add('hidden');
			closeOpeningHourCardsButton.classList.add('hidden');
		});

		/*== Add Opening Hours ==*/
		const addOpeningHoursModal = document.getElementById('addOpeningHoursModal');
		const addOpeningHoursForm = document.getElementById('addOpeningHoursForm');
		const errorAddDay = document.getElementById('error-add-day');
		const errorAddOpeningTime = document.getElementById('error-add-openingTime');
		const errorAddClosingTime = document.getElementById('error-add-closingTime');
		const errorAddIsCurrent = document.getElementById('error-add-isCurrent');

		// Display the add modal
    addOpeningHourButton.addEventListener('click', () => {
      addOpeningHoursModal.classList.remove('hidden');
    });

    // Close the add modal
    document.getElementById('cancelAddOpeningHoursButton').addEventListener('click', () => {
			addOpeningHoursModal.classList.add('hidden');
      clearValues('add');
    });

		// Submit the add form

		/*== Edit Opening Hours ==*/
		const editOpeningHoursModal = document.getElementById('editOpeningHoursModal');
		const editOpeningHoursForm = document.getElementById('editOpeningHoursForm');
		const editOpeningHoursId = document.getElementById('editOpeningHoursId');
		const errorEditDay = document.getElementById('error-edit-day');
		const errorEditOpeningTime = document.getElementById('error-edit-openingTime');
		const errorEditClosingTime = document.getElementById('error-edit-closingTime');
		const errorEditIsCurrent = document.getElementById('error-edit-isCurrent');

		// Display the edit modal and populate the form
		window.openEditOpeningHoursModal = function(openingHourId) {
			editOpeningHoursModal.classList.remove('hidden');
		}
		
		// Close the edit modal
		document.getElementById('cancelEditOpeningHoursButton').addEventListener('click', () => {
			editOpeningHoursModal.classList.add('hidden');
			clearValues('edit');
		});

		// Submit the edit form



		// Clear error messages and input values
    function clearValues(action) {
			if (action === 'edit') {
				/* errorEditMessageHeader.classList.add('hidden');
				errorEditMessageContent.classList.add('hidden'); 
				editOpeningHoursForm.reset();*/
			}
			else if (action === 'add') {
				/* errorAddMessageHeader.classList.add('hidden');
				errorAddMessageContent.classList.add('hidden'); */
				addOpeningHoursForm.reset();
			}
    }

		
	});
</script>