<?php 
include_once "src/model/entity/News.php";
class NewsRepository {

    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance();
    }

    public function getAllNews(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM News");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No news found!");
            }
        } catch (PDOException $e) {
            throw new PDOException('Failed to fetch news!');
        }
        return $result;
    }

    public function getNewsById(int $id): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM News n WHERE n.newsId = :id");
        try {
            $query->execute(array(":id" => $id));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No news found!");
            }
        } catch (PDOException $e) {
            throw new PDOException('Failed to fetch news!');
        }
        return $result;
    }

    public function addNews(array $newsData): bool {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO News (imageURL, header, content) VALUES (:imageURL, :header, :content)");
        try {
            $query->execute(array(":imageURL" => $newsData['imageURL'], ":header" => $newsData['header'], ":content" => $newsData['content']));
        } catch (PDOException $e) {
            throw new PDOException('Failed to add news!');
        }
        return true;
    }
}