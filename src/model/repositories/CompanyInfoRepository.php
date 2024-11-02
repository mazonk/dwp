<?php 
class CompanyInfoRepository {
    private PDO $db;

    public function __construct($dbCon) {
        $this->db = $dbCon;
    }

    /* Get company info */
    public function getCompanyInfo(): array {
        $query = $this->db->prepare("SELECT * FROM CompanyInfo LIMIT 1");
        try {
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No company info found!");
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Error fetching company info!");
        }
    }
}