<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Prepare email
  $mailTo = "dwp@spicypisces.eu"; // Replace with recipient email
  $subject = "Contact Form Submission";
  $headers = "From: " . $email;
  $fullMessage = "You have received an e-mail from " . $email .".\n\n". $message;

  // Send the email
  mail($mailTo, $subject, $fullMessage, $headers);

  header("Location: /dwp/movies?mailsend");
}