<?php
require_once 'session_config.php';
require_once 'src/controller/PaymentController.php';

$paymentController = new PaymentController();
$paymentIds = $paymentController->getIdsByCheckoutSessionId($_GET['checkout_session_id']);

$paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'confirmed');
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
    <h2>Thank you for booking a ticket.</h2>
  </main>
</body>
</html>