<!-- Company Info Display -->
<?php
    require_once "src/controller/CompanyInfoController.php";
    require_once "src/model/entity/CompanyInfo.php";
    $companyInfoController = new CompanyInfoController();
    $companyInfo = $companyInfoController->getCompanyInfo();

    if (is_array($companyInfo) && isset($companyInfo['errorMessage'])) {
        echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($companyInfo['errorMessage']) . "</p>";
    } else {
?>
<div>
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 mx-4">
        <div class="flex items-center mb-4">
            <img src="src/assets/<?php echo htmlspecialchars($companyInfo->getLogoUrl()) ?>" alt="Company Logo" class="w-24 h-24 object-cover rounded-full mr-4">
            <div>
                <h2 class="text-xl font-semibold text-black" id="companyNameDisplay"><?php echo htmlspecialchars($companyInfo->getCompanyName()) ?></h2>
                <p class="text-gray-700" id="companyDescriptionDisplay"><?php echo htmlspecialchars($companyInfo->getCompanyDescription()) ?></p>
            </div>
        </div>
        <?php $companyAddress = $companyInfo->getAddress() ?>
        <div class="flex flex-row space-x-1.5 text-gray-900 mb-2">
            <p id="companyStreetNrDisplay"><?php echo htmlspecialchars($companyAddress->getStreetNr()) ?></p>
            <p id="companyStreetDisplay"><?php echo htmlspecialchars($companyAddress->getStreet()) ?>,</p>
            <p id="companyPostalCodeDisplay"><?php echo htmlspecialchars($companyAddress->getPostalCode()->getPostalCode()) ?></p>
            <p id="companyCityDisplay"><?php echo htmlspecialchars($companyAddress->getPostalCode()->getCity()) ?></p>
        </div>
        <button id="editCompanyInfoButton" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Edit</button>
    </div>

    <!-- Company Info Edit Form -->
    <div id="editForm" class="bg-white shadow-md rounded-lg p-6 mx-4 mb-12 hidden">
        <h2 class="text-xl font-semibold mb-4 text-black">Edit Company Information</h2>
        <form id="companyInfoForm" class="text-black">
            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($companyInfo->getCompanyInfoId())?>">
            <input type="hidden" id="addressIdCI" name="addressIdCI" value="<?php echo htmlspecialchars($companyAddress->getAddressId())?>">
            <input type="hidden" id="postalCodeIdCI" name="postalCodeIdCI" value="<?php echo htmlspecialchars($companyAddress->getPostalCode()->getPostalCodeId())?>">
            <div class="mb-4">
                <label for="companyName" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" id="companyName" name="companyName" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="companyDescription" class="block text-sm font-medium text-gray-700">Company Description</label>
                <textarea id="companyDescription" name="companyDescription" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <div class="flex items-center">
                    <input type="text" id="streetNr" name="streetNr" class="mt-1 block w-1/6 p-2 border border-gray-300 rounded-md mr-2" required>
                    <input type="text" id="street" name="street" class="mt-1 block w-2/6 p-2 border border-gray-300 rounded-md mr-2" required>
                    <input type="text" id="postalCode" name="postalCode" class="mt-1 block w-1/6 p-2 border border-gray-300 rounded-md mr-2" required>
                    <input type="text" id="city" name="city" class="mt-1 block w-2/6 p-2 border border-gray-300 rounded-md" required>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="saveButtonCI" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Save</button>
                <button type="button" id="cancelButton" class="bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 ml-2">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php }?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.getElementById('editCompanyInfoButton');
    const editForm = document.getElementById('editForm');
    const companyInfoForm = document.getElementById('companyInfoForm');
    const errorMessageElement = document.createElement('p');
    errorMessageElement.classList.add('text-red-500', 'text-center', 'font-medium');
    companyInfoForm.prepend(errorMessageElement);

    // Toggle visibility and populate form fields on edit button click
    editButton.addEventListener('click', () => {
        editForm.classList.remove('hidden');
        const companyName = document.getElementById('companyNameDisplay').textContent.trim();
        const companyDescription = document.getElementById('companyDescriptionDisplay').textContent.trim();
        const streetNr = document.getElementById('companyStreetNrDisplay').textContent.trim();
        const street = document.getElementById('companyStreetDisplay').textContent.trim().slice(0, -1); // remove trailing comma
        const postalCode = document.getElementById('companyPostalCodeDisplay').textContent.trim();
        const city = document.getElementById('companyCityDisplay').textContent.trim();

        document.getElementById('companyName').value = companyName;
        document.getElementById('companyDescription').value = companyDescription;
        document.getElementById('streetNr').value = streetNr;
        document.getElementById('street').value = street;
        document.getElementById('postalCode').value = postalCode;
        document.getElementById('city').value = city;
    });

    // Handle form submission
    companyInfoForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('PUT', `${baseRoute}companyInfo/edit`, true);

        // Gather form data
        const updatedCompanyInfo = {
            action: 'editCompanyInfo',
            companyId: document.getElementById('companyId').value,
            companyName: document.getElementById('companyName').value,
            companyDescription: document.getElementById('companyDescription').value,
            addressId: document.getElementById('addressIdCI').value,
            streetNr: document.getElementById('streetNr').value,
            street: document.getElementById('street').value,
            postalCodeId: document.getElementById('postalCodeIdCI').value,
            postalCode: document.getElementById('postalCode').value,
            city: document.getElementById('city').value,
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.response); // Parse the JSON response
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        errorMessageElement.textContent = 'An unexpected error occurred. Please try again.';
                        errorMessageElement.style.display = 'block';
                        return;
                    }

                    if (response.success) {
                        alert('Success! Company information edited successfully.');
                        window.location.reload();
                        errorMessageElement.style.display = 'none'; // Hide the error message if there's success
                    } else {
                        errorMessageElement.textContent = response.errorMessage;
                        errorMessageElement.style.display = 'block';
                        console.error('Error:', response.errorMessage);
                    }
                }
            };

        // Send data as URL-encoded string
        const params = Object.keys(updatedCompanyInfo)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(updatedCompanyInfo[key])}`)
            .join('&');
        xhr.send(params);
    });

    // Cancel button hides the form without submitting
    document.getElementById('cancelButton').addEventListener('click', () => {
        editForm.classList.add('hidden');
    });
});
</script>
