<?php 
include_once "src/model/entity/News.php";
class NewsRepository {

    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance();
    }

    public function get($id = null) {
        $db = $this->getdb();
        $retarray = [];
        $retVal = null;
        try {
            if ($id){
                $query = $db->prepare("SELECT * FROM News n WHERE n.newsId = :id");
                $query->execute(array(":id" => $id));
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $retVal = new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
            } else {
                $query = $db->prepare("SELECT * FROM News");
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row) {
                    $retarray[] = new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
                }
                return $retarray;
            }
        } catch (PDOException $e) {
            echo 'Failed to fetch news: '. $e;
        }
    }
}