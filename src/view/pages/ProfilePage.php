<?php
require_once 'session_config.php';
include_once 'src/controller/UserController.php';

if (!isLoggedIn()) {
    header("Location: " . $_SESSION['baseRoute'] . "login");
    exit;
}

$userController = new UserController();
$user = $userController->getUserById($_SESSION['loggedInUser']['userId']);
if (is_array($user) && isset($user['errorMessage']) && $user['errorMessage']) {
    echo $user['errorMessage'] . ' ' . '<a class="underline text-blue-300" href="javascript:window.history.back()"><-Go back!</a>';
    exit;
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
    <title>Your profile</title>
</head>
<body class="max-w-[90rem] w-[100%] mx-auto mt-[4.5rem] px-[6.25rem] font-sans bg-[#0d0101] text-white m-0 p-[2vw]">
  <?php include_once("src/view/components/Navbar.php"); ?>
    <div class="flex flex-row">
        <div>
            <div class="flex flex-col items-center mb-4 space-y-[2rem]">
                <img src="src/assets/default-profile-picture.png" alt="Company Logo" class="w-[200px] h-[200px] object-cover rounded-full">
                <div class="break-words max-w-[200px]">
                    <p class="text-[1.75rem] text-textLight">
                        <?php echo htmlspecialchars($user->getFirstName()) . ' ' . htmlspecialchars($user->getLastName())?>
                    </p>
                </div>
                <a href="<?php echo $_SESSION['baseRoute']?>edit-profile" 
                class="text-[1rem] font-semibold bg-bgSemiDark py-2 w-full text-center border border-borderDark text-textNormal rounded-[6px]">Edit profile</a>
            </div>
        </div>
        <div>
            
        </div>
    </div>
</body>
</html>

<?php } ?>