<?php 
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once 'src/model/repositories/CompanyInfoRepository.php';
require_once 'src/model/services/AddressService.php';
require_once 'src/model/entity/CompanyInfo.php';
class CompanyInfoService {
    private CompanyInfoRepository $companyInfoRepository;
    private AddressService $addressService;
    private PDO $db;

    public function __construct() {
        $this->db = $this->getdb();
        $this->companyInfoRepository = new CompanyInfoRepository($this->db);
        $this->addressService = new AddressService();
    }

    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

    /* Get company info */
    public function getCompanyInfo(): array|CompanyInfo {
        try {
            $result = $this->companyInfoRepository->getCompanyInfo();
            try {
                $address = $this->addressService->getAddressById($result['addressId']);
                return new CompanyInfo($result['companyInfoId'], $result['companyName'], $result['companyDescription'], $result['logoUrl'], $address);
            } catch (Exception $e) {
                return ["error"=> true, "message"=> $e->getMessage()];
            }
        } catch (PDOException $e) {
            return ["error"=> true, "message"=> $e->getMessage()];
        }
    }

    public function editCompanyInfo(int $companyInfoId, array $newCompanyInfoData): array|CompanyInfo {
        $this->db->beginTransaction();
        try {
            $newAddress = new Address($newCompanyInfoData['addressId'], $newCompanyInfoData['street'], $newCompanyInfoData['streetNr'], 
            new PostalCode($newCompanyInfoData['postalCodeId'], $newCompanyInfoData['postalCode'], $newCompanyInfoData['city']));
            $this->addressService->editAddress($newCompanyInfoData['addressId'], $newAddress);
            $this->companyInfoRepository->editCompanyInfo($companyInfoId, $newCompanyInfoData['companyName'], $newCompanyInfoData['companyDescription'], $newCompanyInfoData['logoUrl']);
          $this->db->commit();
          return $this->getCompanyInfo();
        } catch (Exception $e) {
          $this->db->rollBack();
          return ["error"=> true, "message"=> $e->getMessage()];
        }
      }
}