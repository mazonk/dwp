<?php
require_once 'session_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <?php include_once("src/assets/tailwindConfig.php"); ?>
  <title>Checkout</title>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
  <main class="p-4"> <!-- mt-[56px] needed if there is a navbar -->
    <form action="charge">
      <button type="submit" class="py-[.5rem] px-[1rem] bg-bgSemiDark border-[1px] border-borderDark rounded-[10px]">Pay</button>
    </form>
  </main>
</body>
</html>
