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

  private function validateFormInputs(array $formData, array &$errors): void {
    // Define regexes for validation
    $nameRegex = "/^[a-zA-ZáéíóöúüűæøåÆØÅ\s\-']+$/";
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $messageRegex = "/^[a-zA-Z0-9áéíóöúüűæøåÆØÅ\s\-\.,;:'\"!?]+$/";

    // Perform checks
    if (empty($formData['name']) || empty($formData['email']) || empty($formData['message'])) {
        $errors['general'] = "All fields are required.";
    }
    if (!preg_match($nameRegex, $formData['name'])) {
        $errors['name'] = "Name must only contain letters and spaces.";
    }
    if (strlen($formData['name']) < 2) {
        $errors['firstName'] = "Name must be at least 2 characters long.";
    }
    if (!preg_match($emailRegex, $formData['email'])) {
        $errors['email'] = "Invalid email format.";
    }
    if (!preg_match($messageRegex, $formData['message'])) {
        $errors['message'] = "Message must only contain letters, numbers, and basic punctuation.";
    }
    if(strlen($formData['message']) < 10) {
        $errors['message'] = "Message must be at least 10 characters long.";
    }
  }
}
?>