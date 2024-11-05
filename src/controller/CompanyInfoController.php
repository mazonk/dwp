<?php
require_once 'src/model/services/CompanyInfoService.php';
class CompanyInfoController {
    private CompanyInfoService $companyInfoService;

    public function __construct() {
        $this->companyInfoService = new CompanyInfoService();
    }

    /* Get company info */
    public function getCompanyInfo(): array|CompanyInfo {
        $companyInfo = $this->companyInfoService->getCompanyInfo();
        if (is_array($companyInfo) && isset($companyInfo['error']) && $companyInfo['error']) {
            return ['errorMessage'=> $companyInfo['message']];
        }
        return $companyInfo;
    }

    public function editCompanyInfo(int $companyInfoId, array $newCompanyInfoData): array|CompanyInfo {
        // Validate input data
        $validationErrors = $this->validateInputs($newCompanyInfoData);
        if (!empty($validationErrors)) {
            return ['errorMessage' => implode(', ', $validationErrors)];
        }
    
        // Proceed with the service call if validation passes
        $companyInfo = $this->companyInfoService->editCompanyInfo($companyInfoId, $newCompanyInfoData);
        if (is_array($companyInfo) && isset($companyInfo['error']) && $companyInfo['error']) {
            return ['errorMessage'=> $companyInfo['message']];
        }
        return $companyInfo;
    }

    private function validateInputs(array $data): array {
        $errors = [];
    
        if (empty($data['companyName'] || empty($data['companyDescription']) || empty($data['street']) || empty($data['streetNr']) || empty($data['postalCode']) || empty($data['city']))) {
          $errors[] = 'All fields are required.';
        }
        
        if (strlen($data['companyName']) > 100) {
            $errors[] = 'Company name must not be longer than 100 characters.';
        }

        if (strlen($data['companyDescription']) > 2000) {
            $errors[] = 'Company description must not be longer than 2000 characters.';
        }
    
        if (strlen($data['street']) > 100) {
            $errors[] = 'Street must not be longer than 100 characters.';
        }
    
        if (strlen($data['streetNr']) > 10) {
            $errors[] = 'Street number must not be longer than 10 characters.';
        }
        
        if (strlen($data['city']) > 50) {
            $errors[] = 'City must not be longer than 50 characters.';
        }
    
        if (empty($data['companyName']) || strlen($data['companyName']) < 2) {
            $errors[] = 'Company name must be at least 2 characters long.';
        }

        if (empty($data['companyDescription']) || strlen($data['companyDescription']) < 2) {
            $errors[] = 'Company description must be at least 2 characters long.';
        }
    
        if (empty($data['street']) || strlen($data['street']) < 2) {
            $errors[] = 'Street must be at least 2 characters long.';
        }
    
        if (empty($data['streetNr']) || !is_numeric($data['streetNr'])) {
            $errors[] = 'Street number must be a valid number.';
        }
    
        if (empty($data['postalCode']) || !is_numeric($data['postalCode']) || strlen((string)$data['postalCode']) < 4) {
            $errors[] = 'Postal code must be a valid number with at least 4 digits.';
        }
    
        if (empty($data['city']) || strlen($data['city']) < 2) {
            $errors[] = 'City must be at least 2 characters long.';
        }
    
        return $errors;
      }
}