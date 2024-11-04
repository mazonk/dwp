<?php
require_once 'session_config.php';
session_start();

class ContactFormService {
  public function sendMail() {
    $errors = [];

    if (isset($_POST['submit'])) {
      $formData = {
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message'],
      };

      // Validate the form data inputs
      $this->validateContactForm($formData, $errors);

      $subject = "Contact Form Submission";
      $mailTo = "dwp@spicypisces.eu";
      $headers = "From: " . $formsData['email'];
      $txt = "You have received an email from " . $formsData['name'] . ".\n\n" . $formsData['message'];
      // Current route where the form was submitted
      $currentRoute = $_POST['route'];
      
      // Attempt to send the email
      if (mail($mailTo, $subject, $txt, $headers)) {
        // Email sent successfully
        header("Location: " . $currentRoute . "?status=success"); // Redirect with success
        exit();
      } else {
          // Failed to send email
          header("Location: " . $currentRoute . "?status=failed"); // Redirect with failure
          exit();
      }
    }
  }

  
}
?>