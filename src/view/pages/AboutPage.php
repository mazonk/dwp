<?php
require_once 'session_config.php';
include_once 'src/controller/CompanyInfoController.php';
include_once 'src/controller/VenueController.php';

$companyInfoController = new CompanyInfoController();
$companyInfo = $companyInfoController->getCompanyInfo();

$venueController = new VenueController();
$allVenues = $venueController->getAllVenues();

$selectedVenue = $venueController->getSelectedVenue();
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
    <main>
    <div class="mt-[56px] py-4">
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
        <?php }?>
        <?php
            if (isset($allVenues['errorMessage'])) {
                echo $allVenues['errorMessage'];
                exit;
            } else if (is_array($selectedVenue) && isset($selectedVenue['errorMessage'])) {
                echo $selectedVenue['errorMessage'];
                exit;
            } else {?>
            <div class="flex flex-row justify-between my-8">
                <div class="w-[300px]">
                    <h2 class="text-[1.875rem] leading-snug mb-7 mt-11">Our Venues</h2>
                    <?php foreach ($allVenues as $venue) {?>
                        <div class="flex items-center mb-4">
                            <div>
                                <h3 data-venue-id="<?php echo htmlspecialchars($venue->getVenueId()) ?>"
                                    class="venueSelectButton text-[1rem] leading-snug <?php echo $venue->getVenueId() === $selectedVenue->getVenueId() ? 'font-bold text-primary' : 'text-gray-300 hover:underline cursor-pointer' ?>">
                                    <?php echo htmlspecialchars($venue->getName())?>
                                </h3>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div id="venue-info" class="mt-8 border rounded-3xl bg-bgSemiDark border-borderDark pt-4 pb-8 w-[500px] mx-auto">
                    <h3 class="text-center text-[1.875rem]"><?php echo htmlspecialchars($selectedVenue->getName())?></h3>
                    <div class="grid grid-cols-2 mt-[1.75rem] text-textNormal">
                        <div class="max-w-[250px] flex flex-col gap-[1.5rem] items-left pl-[2rem]">
                            <h4 class="text-[1.125rem] font-bold leading-tight">Opening Hours</h4>
                            <div class="flex flex-col gap-[.75rem]">
                                <?php
                                include_once 'src/controller/OpeningHourController.php';
                                $openingHourController = new OpeningHourController();
                                $openingHours = $openingHourController->getOpeningHoursById($_SESSION['selectedVenueId']);

                                if(isset($openingHours['errorMessage'])) {
                                echo "<div class='text-[.875rem] text-textNormal leading-snug'>" . htmlspecialchars($openingHours['errorMessage']) . "</div>";
                                }

                                foreach ($openingHours as $openingHour) {
                                echo 
                                    "<div class='w-fit text-[.875rem] text-textNormal leading-snug'>" .
                                    "<span class='font-medium'>" . htmlspecialchars($openingHour->getDay()) . ": </span>" .
                                    "<span>" . htmlspecialchars($openingHour->getOpeningTime()->format('H:i')) . " - " . htmlspecialchars($openingHour->getClosingTime()->format('H:i')) . "</span>" .
                                    "</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="max-w-[250px] flex flex-col gap-[1.5rem] items-left">
                            <h4 class="text-[1.125rem] font-bold leading-tight">Where can you find us?</h4>
                            <div class="text-[.875rem] text-textNormal leading-snug">
                                <?php echo htmlspecialchars($selectedVenue->getAddress()->getStreetNr()) . ' ' . htmlspecialchars($selectedVenue->getAddress()->getStreet())
                                . ', ' . htmlspecialchars($selectedVenue->getAddress()->getPostalCode()->getPostalCode()) . ' ' . htmlspecialchars($selectedVenue->getAddress()->getPostalCode()->getCity()) ?>
                            </div>
                            <div class="mt-4 w-full flex flex-col gap-4">
                                <h4 class="text-[1.125rem] font-bold leading-tight text-left mt-[0.5rem]">Reach out to us at:</h4>
                                <div class="flex flex-col items-left justify-center">
                                    <div class="flex flex-col w-fit text-[.875rem] text-textNormal leading-snug space-y-4">
                                        <a href="mailto:<?= htmlspecialchars($selectedVenue->getContactEmail()) ?>" class="hover:text-textLight underline">
                                            <?= htmlspecialchars($selectedVenue->getContactEmail())?>
                                        </a>
                                        <span class="text-center">OR</span>
                                        <div class="text-center">
                                            Call us: <?= htmlspecialchars($selectedVenue->getPhoneNr())?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
        
    </main>

    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>

<script>
    document.querySelectorAll('.venueSelectButton').forEach(button => {
    button.addEventListener('click', () => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.reload();
            }
        };
        const venueId = button.dataset.venueId;
        xhr.send(`action=${`selectVenue&venueId=${venueId}`}`);
    });
});

</script>