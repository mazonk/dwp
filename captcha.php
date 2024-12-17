<?php
// Generate a random string for the CAPTCHA (5 characters)
$captchaText = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 5);

// Store the CAPTCHA text in a session variable for verification later
$_SESSION['captcha'] = $captchaText;

// Output the CAPTCHA text for display
echo "<div id='captcha' class='text-white bg-primaryDark border flex justify-center border-borderDark py-[.5rem] rounded-[6px] text-[.875rem] font-medium leading-snug'>CAPTCHA code: &nbsp;&nbsp;<strong>" . htmlspecialchars($captchaText) . "</strong></div>";

