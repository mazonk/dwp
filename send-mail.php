<?php
// Function to send an email using One.com SMTP
function sendMail($to, $subject, $message, $from) {
  // SMTP server settings
  $smtpHost = 'send.one.com'; // One.com SMTP server
  $smtpPort = 587;  // Use 465 for SSL, 587 for TLS
  $smtpUser = 'info@yourdomain.com'; // Your One.com email address
  $smtpPass = 'your-email-password';  // Your One.com email password

  // Open socket connection to SMTP server
  $socket = stream_socket_client("tcp://$smtpHost:$smtpPort, $errno, $errstr, 30");
  if (!$socket) {
    echo "Failed to connect to the SMTP server: $errstr ($errno)";
    return false;
  }

  // SMTP conversation
  $smtpCommands = [
    "EHLO localhost",
    "AUTH LOGIN",
    base64_encode($smtpUser), // Username converted to base64
    base64_encode($smtpPass), // Password converted to base64
    "MAIL FROM:<$from>",
    "RCPT TO:<$to>",
    "DATA",
    "Subject: $subject\r\n\r\n$message\r\n.",
    "QUIT"
  ]

  foreach($smtpCommands ad $cmd) {
    fwrite($socket, "$cmd\r\n");
  }

  // Close the connection
  fclose($socket);
  echo "Email sent!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Prepare email
  $to = "tolnainorbi16@gmail.com"; // Replace with recipient email
  $subject = "Contact Form Submission from $email";
  $fullMessage = "Email: $email\nMessage: $message";

  // Send the email
  sendMail($to, $subject, $fullMessage, $email);
}