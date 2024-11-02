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
}