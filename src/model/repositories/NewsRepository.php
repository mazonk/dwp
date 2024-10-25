<?php 
include_once "src/model/entity/News.php";
class NewsRepository {

    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance();
    }

    public function getNewsById($id): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM News n WHERE n.newsId = :id");
        try {
            $query->execute(array(":id" => $id));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
        return $result;
    }

    public function getAll() {
        $db = $this->getdb();
        try {
            $query = $db->prepare("SELECT * FROM  s");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
        return $result;
    }
}