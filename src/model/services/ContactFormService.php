<?php
require_once 'session_config.php';
session_start();

class ContactFormService {
  public function sendMail() {
    $errors = [];

    if (isset($_POST['submit'])) {
      $formData = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message'],
      ];

      // Validate the form data inputs
      $this->validateFormInputs($formData, $errors);

      //Sanitize the form data
      $formData['name'] = htmlspecialchars(trim($formData['name']));
      $formData['email'] = htmlspecialchars(trim($formData['email']));
      $formData['message'] = htmlspecialchars(trim($formData['message']));

      $subject = "Contact Form Submission";
      $mailTo = "dwp@spicypisces.eu";
      $headers = "From: " . $formData['email'];
      $txt = "You have received an email from " . $formData['name'] . ".\n\n" . $formData['message'];
      // Current route where the form was submitted
      $currentRoute = filter_var(trim($_POST['route']), FILTER_SANITIZE_URL);

      if(count($errors) == 0) {
         // Send email and handle success/failure
         if (mail($mailTo, $subject, $txt, $headers)) {
          unset($_SESSION['contactErrors']);
          header("Location: " . $currentRoute . "?status=success");
        } else {
          $_SESSION['contactErrors']['general'] = "Failed to send email.";
          header("Location: " . $currentRoute . "?status=failed");
        }      
      } else {
        // Redirect with validation errors
        $_SESSION['contactErrors'] = $errors;
        header("Location: " . $currentRoute . "?status=failed");
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
        $errors['name'] = "Name must be at least 2 characters long.";
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