<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWP Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>
<body class="w-[100%] mx-auto mb-[2rem] bg-bgDark text-textLight overflow-hidden max-h-screen">
    <div class="flex">
        <!-- Include the Admin Sidebar -->
        <?php include 'src/view/components/AdminSidebar.php'; ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-8 bg-gray-900 text-gray-100">
            <?php
                require_once 'session_config.php';

                if (!isLoggedIn() || $_SESSION['loggedInUser']['roleType'] !== "Admin") {
                    http_response_code(403);
                    echo '<div class="text-4xl font-bold text-red-600">Nice try, but forbidden!</div>';
                    exit;
                } else {
//                    echo '<div class="text-2xl font-bold text-green-600 flex justify-center">Welcome, '. $_SESSION['loggedInUser']['firstName'] . ' ' . $_SESSION['loggedInUser']['lastName'].'!</div>';
                }
            ?>
            <?php
                $section = $_GET['section'] ?? 'company-venues'; // Default to 'company-venues' if no section is specified

                switch ($section) {
                    case 'company-venues':
                        include 'src/view/components/admin-sections/companyVenues.php';
                        break;
                    case 'content-management':
                        include 'src/view/components/admin-sections/contentManagement.php';
                        break;
                    case 'scheduling':
                        include 'src/view/components/admin-sections/scheduling.php';
                        break;
                    case 'bookings-invoices':
                        include 'src/view/components/admin-sections/bookingsInvoices.php';
                        break;
                    default:
                        echo '<div class="text-2xl font-bold text-red-600">Section not found!</div>';
                        break;
                }
            ?>
        </main>
    </div>
</body>
</html>
