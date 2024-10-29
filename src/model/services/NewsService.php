<?php
include_once "src/model/repositories/NewsRepository.php";
class NewsService {
    private NewsRepository $newsRepository;

    public function __construct() {
        $this->newsRepository = new NewsRepository();
    }

    public function getAllNews(): array {
        try {
            $result = $this->newsRepository->getAllNews();
            $news = [];
            foreach ($result as $row) {
                $news[] = new News($row['newsId'], $row['imageURL'], $row['header'], $row['content']);
            }
        } catch (Exception $e) {
            return ["error" => true, 'message' => $e->getMessage()];
        }
        
        return $news;
    }

    public function getNewsById(int $id): array|News {
        try {
            $result = $this->newsRepository->getNewsById($id);
            return new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
        } catch (Exception $e) {
            return ["error" => true, 'message' => $e->getMessage()];
        }
        
    }
}