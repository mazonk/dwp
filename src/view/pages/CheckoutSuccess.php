<?php  require_once 'session_config.php';

// Get booking details from session
if (!isset($_SESSION['activeBooking']) && !isset($_SESSION['checkoutSession'])) {
  echo  'Page is unavailable as you have not made any purchase!' . ' ' . '<a class="underline text-blue-300" href="javascript:window.history.back()"><-Go back!</a>';
  exit();
}

unset($_SESSION['activeBooking']);
unset($_SESSION['checkoutSession']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <?php include_once("src/assets/tailwindConfig.php"); ?>
  <title>Successfull checkout</title>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
  <main class="p-4"> <!-- mt-[56px] needed if there is a navbar -->
    <div class="flex flex-col items-center justify-center gap-[1rem]">
      <h1 class="text-4xl font-bold text-center">Thank you for booking a ticket!</h1>
      <p class="text-lg text-center">The invoice of your purchase has been sent to you in email.</p>
      <a href="<?php echo $_SESSION['baseRoute']?>home" class="mt-[1rem] py-[.625rem] px-[1.25rem] bg-primary text-textDark font-medium leading-tight rounded-[8px] ease-in-out duration-[.15s] hover:bg-primaryHover">Return to homepage</a>
    </div>
  </main>
</body>
</html>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Clear the bookingExpiry localStorage item
    localStorage.removeItem('bookingExpiry');
  });
</script>