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
											<p id="error-add-openingHour-day"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex gap-[1rem]">
											<div class="w-full mb-4">
													<label for="addOpeningTimeInput" class="block text-sm font-medium text-text-textLight">Opening Time</label>
													<input id="addOpeningTimeInput" name="addOpeningTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-add-openingHour-openingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
											<div class="w-full mb-4">
													<label for="addClosingTimeInput" class="block text-sm font-medium text-text-textLight">Closing Time</label>
													<input id="addClosingTimeInput" name="addClosingTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-add-openingHour-closingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
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
											<p id="error-add-openingHour-isCurrent" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<p id="error-add-openingHour-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
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
											<p id="error-edit-openingHour-day"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<div class="flex gap-[1rem]">
											<div class="w-full mb-4">
													<label for="editOpeningTimeInput" class="block text-sm font-medium text-text-textLight">Opening Time</label>
													<input id="editOpeningTimeInput" name="editOpeningTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-edit-openingHour-openingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
											</div>
											<div class="w-full mb-4">
													<label for="editClosingTimeInput" class="block text-sm font-medium text-text-textLight">Closing Time</label>
													<input id="editClosingTimeInput" name="editClosingTimeInput" type="time" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
													<p id="error-edit-openingHour-closingTime" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
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
											<p id="error-edit-openingHour-isCurrent" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									</div>
									<p id="error-edit-openingHour-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
									<div class="flex justify-end">
											<button type="submit" id="saveEditOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Save</button>
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
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Delete Opening Hour</h2>
                <p class="text-textLight text-center">Are you sure you want to delete this opening hour?</p>
                <p id="deleteModalOpeningHourContent" class="text-gray-400 text-center"></p>
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
		const errorAddOpeningHourDay = document.getElementById('error-add-openingHour-day');
		const errorAddOpeningHourOpeningTime = document.getElementById('error-add-openingHour-openingTime');
		const errorAddOpeningHourClosingTime = document.getElementById('error-add-openingHour-closingTime');
		const errorAddOpeningHourIsCurrent = document.getElementById('error-add-openingHour-isCurrent');
		const errorAddOpeningHourGeneral = document.getElementById('error-add-openingHour-general');



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
						console.log(response.errors);
						// Display error messages
						if (response.errors['day']) {
							errorAddOpeningHourDay.textContent = response.errors['day'];
							errorAddOpeningHourDay.classList.remove('hidden');
						}
						if (response.errors['openingTime']) {
							errorAddOpeningHourOpeningTime.textContent = response.errors['openingTime'];
							errorAddOpeningHourOpeningTime.classList.remove('hidden');
						}
						if (response.errors['closingTime']) {
							console.log(response.errors['closingTime']);
							errorAddOpeningHourClosingTime.textContent = response.errors['closingTime'];
							errorAddOpeningHourClosingTime.classList.remove('hidden');
						}
						if (response.errors['isCurrent']) {
							errorAddOpeningHourIsCurrent.textContent = response.errors['isCurrent'];
							errorAddOpeningHourIsCurrent.classList.remove('hidden');
						}
            if (response.errors['general']) {
							errorAddOpeningHourGeneral.textContent = response.errors['general'];
							errorAddOpeningHourGeneral.classList.remove('hidden');
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
		const editDayInput = document.getElementById('editDayInput');
		const editOpeningTimeInput = document.getElementById('editOpeningTimeInput');
		const editClosingTimeInput = document.getElementById('editClosingTimeInput');
		const editIsCurrentInput = document.getElementById('editIsCurrentInput');
		const errorEditOpeningHourDay = document.getElementById('error-edit-openingHour-day');
		const errorEditOpeningHourOpeningTime = document.getElementById('error-edit-openingHour-openingTime');
		const errorEditOpeningHourClosingTime = document.getElementById('error-edit-openingHour-closingTime');
		const errorEditOpeningHourIsCurrent = document.getElementById('error-edit-openingHour-isCurrent');
		const errorEditOpeningHourGeneral = document.getElementById('error-edit-openingHour-general');

		// Display the edit modal and populate the form
		window.openEditOpeningHourModal = function(openingHourData) {
			const data = JSON.parse(openingHourData);
			editOpeningHourId.value = data.id;
			editDayInput.value = data.day;
			editOpeningTimeInput.value = data.openingTime;
			editClosingTimeInput.value = data.closingTime;
			editIsCurrentInput.value = data.isCurrent === true ? '1' : '0';

			editOpeningHourModal.classList.remove('hidden');
		}
		
		// Close the edit modal
		document.getElementById('cancelEditOpeningHourButton').addEventListener('click', () => {
			editOpeningHourModal.classList.add('hidden');
			clearValues('edit');
		});

		// Submit the edit form
		editOpeningHourForm.addEventListener('submit', function(event) {
			event.preventDefault(); // Prevent default form submission
			const xhr = new XMLHttpRequest();
			const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
			xhr.open('PUT', `${baseRoute}openingHours/edit`, true);

			const editOpeningHourData = {
				action: 'editOpeningHour',
				openingHourId: editOpeningHourId.value,
				day: editDayInput.value,
				openingTime: editOpeningTimeInput.value,
				closingTime: editClosingTimeInput.value,
				isCurrent: editIsCurrentInput.value
			};

			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					let response;
					try {
						response = JSON.parse(xhr.response);
					} catch (e) {
						console.error('Could not parse response as JSON:', e);
						return;
					}

					if (response.success) {
						alert('Success! Opening hour edited successfully.');
						window.location.reload();
						clearValues('edit');
					} else {
						// Display error messages
						if (response.errors['day']) {
							errorEditOpeningHourDay.textContent = response.errors['day'];
							errorEditOpeningHourDay.classList.remove('hidden');
						}
						if (response.errors['openingTime']) {
							errorEditOpeningHourOpeningTime.textContent = response.errors['openingTime'];
							errorEditOpeningHourOpeningTime.classList.remove('hidden');
						}
						if (response.errors['closingTime']) {
							errorEditOpeningHourClosingTime.textContent = response.errors['closingTime'];
							errorEditOpeningHourClosingTime.classList.remove('hidden');
						}
						if (response.errors['isCurrent']) {
							errorEditOpeningHourIsCurrent.textContent = response.errors['isCurrent'];
							errorEditOpeningHourIsCurrent.classList.remove('hidden');
						}
						if (response.errors['general']) {
							errorEditOpeningHourGeneral.textContent = response.errors['general'];
							errorEditOpeningHourGeneral.classList.remove('hidden');
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
			const params = Object.keys(editOpeningHourData)
				.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(editOpeningHourData[key])}`)
				.join('&');
			xhr.send(params);
			
		});

		/*== Delete Opening Hour ==*/
		const deleteOpeningHourModal = document.getElementById('deleteOpeningHourModal');
		const deleteModalOpeningHourContent = document.getElementById('deleteModalOpeningHourContent');
		const confirmDeleteOpeningHourButton = document.getElementById('confirmDeleteOpeningHourButton');
		const cancelDeleteOpeningHourButton = document.getElementById('cancelDeleteOpeningHourButton');
		const deleteOpeningHourId = document.getElementById('deleteOpeningHourId');

		// Display the delete modal
		window.openDeleteOpeningHourModal = function(openingHourData) {
			const deleteOpeningHourData = JSON.parse(openingHourData);
			deleteOpeningHourId.value = deleteOpeningHourData.id;
			deleteModalOpeningHourContent.textContent = deleteOpeningHourData.day + ' ' + deleteOpeningHourData.openingTime + ' - ' + deleteOpeningHourData.closingTime;

			deleteOpeningHourModal.classList.remove('hidden');
		}

		// Close the delete modal
		cancelDeleteOpeningHourButton.addEventListener('click', () => {
			deleteOpeningHourModal.classList.add('hidden');
		});

		// Confirm delete
		confirmDeleteOpeningHourButton.addEventListener('click', () => {
			const xhr = new XMLHttpRequest();
			const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
			const openingHourId = deleteOpeningHourId.value;

			xhr.open('DELETE', `${baseRoute}openingHours/delete?openingHourId=${encodeURIComponent(openingHourId)}&action=deleteOpeningHour`, true); // openingHourId as query parameter with action

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

					if (response.success) {
						alert('Success! Opening hour deleted successfully.');
						window.location.reload();
					} else {
						console.error('Error:', response.errorMessage);
					}
				}
			};
			xhr.send();
		});

		// Clear error messages and input values
    function clearValues(action) {
			if (action === 'edit') {
				errorEditOpeningHourDay.classList.add('hidden');
				errorEditOpeningHourOpeningTime.classList.add('hidden');
				errorEditOpeningHourClosingTime.classList.add('hidden');
				errorEditOpeningHourIsCurrent.classList.add('hidden');
				errorEditOpeningHourGeneral.classList.add('hidden');
				editOpeningHourForm.reset();
			}
			else if (action === 'add') {
				errorAddOpeningHourDay.classList.add('hidden');
				errorAddOpeningHourOpeningTime.classList.add('hidden');
				errorAddOpeningHourClosingTime.classList.add('hidden');
				errorAddOpeningHourIsCurrent.classList.add('hidden');
				errorAddOpeningHourGeneral.classList.add('hidden');
				addOpeningHourForm.reset();
			}
    }

		
	});
</script>