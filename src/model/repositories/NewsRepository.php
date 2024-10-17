<?php 
include_once "src/model/entity/News.php";
class NewsRepository {

    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance();
    }

    public function get($id): News {
        $db = $this->getdb();
        try {
            $query = $db->prepare("SELECT * FROM News n WHERE n.newsId = :id");
            $query->execute(array(":id" => $id));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
        return new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
    }

    public function getAll(): array {
        $db = $this->getdb();
        $retarray = [];
        try {
            $query = $db->prepare("SELECT * FROM News");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $retarray[] = new News($row['newsId'], $row['imageURL'], $row['header'], $row['content']);
            }
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
        return $retarray;
    }
}