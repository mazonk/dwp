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
        <p class="text-gray-900 mb-2" id="companyAddressDisplay">
            <?php echo htmlspecialchars($companyAddress->getStreetNr() . ' ' . 
            $companyAddress->getStreet() . ', ' . $companyAddress->getPostalCode()->getPostalCode() . ' ' . $companyAddress->getPostalCode()->getCity()) ?>
        </p>
        <button id="editCompanyInfoButton" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Edit</button>
    </div>

    <!-- Company Info Edit Form -->
    <div id="editForm" class="bg-white shadow-md rounded-lg p-6 mx-4 hidden">
        <h2 class="text-xl font-semibold mb-4 text-black">Edit Company Information</h2>
        <form id="companyInfoForm">
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
                <input type="text" id="address" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Save</button>
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

    editButton.addEventListener('click', (event) => {
        editForm.classList.remove('hidden');
        
    });

    
});

</script>