<?php
require_once "src/model/services/ContactFormService.php";

class ContactFormController {
  private ContactFormService $contactFormService;

  public function __construct() {
    $this->contactFormService = new ContactFormService();
  }

  public function sendMail(): void {
    $errors = $this->contactFormService->sendMail();

    // Current route where the form was submitted
    $currentRoute = filter_var(trim($_POST['route']), FILTER_SANITIZE_URL);

    if(count($errors) == 0) {
       $_SESSION['contactSuccess'] = "Email sent successfully.";
       header("Location: " . $currentRoute . "?status=success");
     } else {
      $_SESSION['contactErrors'] = $errors;
      header("Location: " . $currentRoute . "?status=failed");
     }      
  }
}
?>