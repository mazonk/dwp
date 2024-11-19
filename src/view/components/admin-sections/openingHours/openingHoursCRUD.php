<?php
require_once "src/controller/OpeningHourController.php";
require_once "src/view/components/admin-sections/openingHours/OpeningHoursCard.php";
?>

<div>
  <div class="flex justify-between my-[2rem]">
      <h3 class="text-[1.5rem] font-semibold">
				Opening Hours
			</h3>
      <button id="addOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover">
				Add New
			</button>
  </div>
	<!-- Display all opening hours in cards -->
	<?php
	$openingHourController = new OpeningHourController();
	$openingHours = $openingHourController->getOpeningHours();
	?>
	<div class="grid grid-cols-5 gap-4">
		<?php
		if (isset($openingHours['errorMessage'])) {
				echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($openingHours['errorMessage']) . "</p>";
		} else {
				foreach ($openingHours as $openingHour) {
						OpeningHoursCard::render($openingHour);
				}
		}
		?>
	</div>

	<!-- Add Opening Hour Form Modal -->
	<div id="addOpeningHourModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
			<div class="flex items-center justify-center min-h-screen">
					<!-- Modal -->
					<div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
							<h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Opening Hour</h2>
							<form id="addOpeningHourForm" class="text-textLight">
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
									<p id="error-add-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									<div class="flex justify-end">
											<button type="submit" id="saveAddOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
											<button type="button" id="cancelAddOpeningHourButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
									</div>
							</form>
					</div>
			</div>
  </div>

	<!-- Edit Opening Hour Form Modal -->
	<div id="editOpeningHourModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
			<div class="flex items-center justify-center min-h-screen">
					<!-- Modal -->
					<div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
							<h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Opening Hour</h2>
							<form id="editOpeningHourForm" class="text-textLight">
									<input type="hidden" id="editOpeningHourId" name="editOpeningHourId">
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
											<button type="submit" id="saveEditOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
											<button type="button" id="cancelEditOpeningHourButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
									</div>
							</form>
					</div>
			</div>
  </div>

	<!-- Delete Opening Hour Modal -->
	<div id="deleteOpeningHourModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Delete Opening Hours</h2>
                <p class="text-textLight text-center">Are you sure you want to delete this opening hour?</p>
                <p id="deleteModalOpeningHourHeader" class="text-gray-400 text-center"></p>
                <input type="hidden" id="deleteOpeningHourId" name="deleteOpeningHourId">
                <div class="flex justify-center mt-4">
                    <button id="confirmDeleteOpeningHourButton" class="bg-red-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-red-600 duration-[.2s] ease-in-out">Delete</button>
                    <button id="cancelDeleteOpeningHourButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		/*== Add Opening Hour ==*/
		const addOpeningHourModal = document.getElementById('addOpeningHourModal');
		const addOpeningHourForm = document.getElementById('addOpeningHourForm');
		const addOpeningHourButton = document.getElementById('addOpeningHourButton');
		const errorAddDay = document.getElementById('error-add-day');
		const errorAddOpeningTime = document.getElementById('error-add-openingTime');
		const errorAddClosingTime = document.getElementById('error-add-closingTime');
		const errorAddIsCurrent = document.getElementById('error-add-isCurrent');
		const errorAddGeneral = document.getElementById('error-add-general');



		// Display the add modal
    addOpeningHourButton.addEventListener('click', () => {
      addOpeningHourModal.classList.remove('hidden');
    });

    // Close the add modal
    document.getElementById('cancelAddOpeningHourButton').addEventListener('click', () => {
			addOpeningHourModal.classList.add('hidden');
      clearValues('add');
    });

		// Submit the add form
		addOpeningHourForm.addEventListener('submit', function(event) {
			event.preventDefault(); // Prevent default form submission
			const xhr = new XMLHttpRequest();
			const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
			xhr.open('POST', `${baseRoute}openingHours/add`, true);

			const openingHourData = {
					action: 'addOpeningHour',
					day: document.getElementById('addDayInput').value,
					openingTime: document.getElementById('addOpeningTimeInput').value,
					closingTime: document.getElementById('addClosingTimeInput').value,
					isCurrent: document.getElementById('addIsCurrentInput').value
			}

			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
				// If the request is done and successful
				if (xhr.readyState === 4 && xhr.status === 200) {
					let response;
					try {
						response = JSON.parse(xhr.response); // Parse the JSON response
					} catch (e) {
						console.error('Could not parse response as JSON:', e);
						return;
					}

					if (response.success) {
						alert('Success! Opening hour added successfully.');
						window.location.reload();
						clearValues('add');
					} else {
						// Display error messages
						if (response.errors['day']) {
							errorAddDay.textContent = response.errors['day'];
							errorAddDay.classList.remove('hidden');
						}
						if (response.errors['openingTime']) {
							errorAddOpeningTime.textContent = response.errors['openingTime'];
							errorAddOpeningTime.classList.remove('hidden');
						}
						if (response.errors['closingTime']) {
							errorAddClosingTime.textContent = response.errors['closingTime'];
							errorAddClosingTime.classList.remove('hidden');
						}
						if (response.errors['isCurrent']) {
							errorAddIsCurrent.textContent = response.errors['isCurrent'];
							errorAddIsCurrent.classList.remove('hidden');
						}
						if (response.errors['general']) {
							errorAddGeneral.textContent = response.errors['general'];
							errorAddGeneral.classList.remove('hidden');
						}
						if (response.errorMessage) {
							console.error('Error:', response.errorMessage);
						} else {
							console.error('Error:', response.errors);
						}
					}
				}
			};

			// Send data as URL-encoded string
			const params = Object.keys(openingHourData)
				.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(openingHourData[key])}`)
				.join('&');
			xhr.send(params);
		});

		/*== Edit Opening Hour ==*/
		const editOpeningHourModal = document.getElementById('editOpeningHourModal');
		const editOpeningHourForm = document.getElementById('editOpeningHourForm');
		const editOpeningHourId = document.getElementById('editOpeningHourId');
		const errorEditDay = document.getElementById('error-edit-day');
		const errorEditOpeningTime = document.getElementById('error-edit-openingTime');
		const errorEditClosingTime = document.getElementById('error-edit-closingTime');
		const errorEditIsCurrent = document.getElementById('error-edit-isCurrent');

		// Display the edit modal and populate the form
		window.openEditOpeningHourModal = function(openingHourData) {
			editOpeningHourModal.classList.remove('hidden');
			const editOpeningHourData = JSON.parse(openingHourData);
		}
		
		// Close the edit modal
		document.getElementById('cancelEditOpeningHourButton').addEventListener('click', () => {
			editOpeningHourModal.classList.add('hidden');
			clearValues('edit');
		});

		// Submit the edit form

		/*== Delete Opening Hour ==*/
		const deleteOpeningHourModal = document.getElementById('deleteOpeningHourModal');
		const deleteModalOpeningHourHeader = document.getElementById('deleteModalOpeningHourHeader');
		const confirmDeleteOpeningHourButton = document.getElementById('confirmDeleteOpeningHourButton');
		const cancelDeleteOpeningHourButton = document.getElementById('cancelDeleteOpeningHourButton');
		const deleteOpeningHourId = document.getElementById('deleteOpeningHourId');

		// Display the delete modal
		window.openDeleteOpeningHourModal = function(openingHourId) {
			deleteOpeningHourModal.classList.remove('hidden');
		}

		// Close the delete modal
		cancelDeleteOpeningHourButton.addEventListener('click', () => {
			deleteOpeningHourModal.classList.add('hidden');
		});

		// Confirm delete

		// Clear error messages and input values
    function clearValues(action) {
			if (action === 'edit') {
				/* errorEditMessageHeader.classList.add('hidden');
				errorEditMessageContent.classList.add('hidden'); */ 
				editOpeningHourForm.reset();
			}
			else if (action === 'add') {
				errorAddDay.classList.add('hidden');
				errorAddOpeningTime.classList.add('hidden');
				errorAddClosingTime.classList.add('hidden');
				errorAddIsCurrent.classList.add('hidden');
				errorAddGeneral.classList.add('hidden');
				addOpeningHourForm.reset();
			}
    }

		
	});
</script>