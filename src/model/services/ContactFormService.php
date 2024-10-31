<?php
require_once 'session_config.php';
session_start();

class ContactFormService {
  public function sendMail() {
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $subject = "Contact Form Submission";
      $mailFrom = $_POST['email'];
      $message = $_POST['message'];
    
      $mailTo = "dwp@spicypisces.eu";
      $headers = "From: " . $mailFrom;
      $txt = "You have received an email from " . $name . ".\n\n" . $message;

      // Current route where the form was submitted
      $route = $_POST['route'];
      
      // Attempt to send the email
      if (mail($mailTo, $subject, $txt, $headers)) {
        // Email sent successfully
        header("Location: " . $route . "?status=success"); // Redirect with success
        exit();
      } else {
          // Failed to send email
          header("Location: " . $route . "?status=failed"); // Redirect with failure
          exit();
      }
    }
  }
}
?>