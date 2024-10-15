<?php 
include_once "src/model/entity/News.php";
class NewsRepository {

    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance();
    }

    public function getAll() {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM News");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
        $retarray = [];
        foreach($result as $row) {
            $retarray[] = new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
        }
        return $retarray;
    }
}