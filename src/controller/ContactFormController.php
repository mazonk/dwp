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
       $queryStr = parse_url($currentRoute, PHP_URL_QUERY);
       $queryStr = empty($queryStr) ? '?status=success' : "&status=success";
       header("Location: " . $currentRoute . $queryStr);
     } else {
      $_SESSION['contactErrors'] = $errors;
      $queryStr = parse_url($currentRoute, PHP_URL_QUERY);
       $queryStr = empty($queryStr) ? '?status=failed' : "&status=failed";
       header("Location: " . $currentRoute . $queryStr);
     }      
  }
}
?>