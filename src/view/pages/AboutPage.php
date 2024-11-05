<?php
require_once 'session_config.php';
include_once 'src/controller/CompanyInfoController.php';
include_once 'src/controller/VenueController.php';

$companyInfoController = new CompanyInfoController();
$companyInfo = $companyInfoController->getCompanyInfo();

$venueController = new VenueController();
$selectedVenue = $venueController->getVenueById($_SESSION['selectedVenueId']);

if (is_array($selectedVenue) && isset($selectedVenue['errorMessage'])) {
    echo $selectedVenue['errorMessage'];
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
        <?php 
        if (is_array($companyInfo) && isset($companyInfo['errorMessage'])) {
            echo $companyInfo['errorMessage'];
            exit;
        } else { ?>
        <h1 class="text-[1.875rem] mb-8">About <?php echo htmlspecialchars($companyInfo->getCompanyName()) ?></h1>
        <div class="flex items-center mb-4">
            <img src="src/assets/<?php echo htmlspecialchars($companyInfo->getLogoUrl())?>" alt="Company Logo" class="w-24 h-24 object-cover rounded-full mr-4">
            <div>
                <p class="text-lg text-textLight"><?php echo htmlspecialchars($companyInfo->getCompanyDescription())?></p>
            </div>
        </div>
        </div>
        <?php }?>
    </main>

    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>