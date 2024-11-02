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
}