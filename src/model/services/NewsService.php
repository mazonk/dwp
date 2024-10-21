<?php
include_once "src/model/repositories/NewsRepository.php";
class NewsService {
    private NewsRepository $newsRepository;

    public function __construct() {
        $this->newsRepository = new NewsRepository();
    }

    public function getNews($id = null): array {
        $result = $this->newsRepository->getAll();
        $news = [];

        foreach ($result as $row) {
            $news[] = new News($row['newsId'], $row['imageURL'], $row['header'], $row['content']);
        }
        return $news;
    }

    public function getNewsById($id): ?News {
        $result = $this->newsRepository->get($id);
        if ($result) {
            return new News($result['newsId'], $result['imageURL'], $result['header'], $result['content']);
        } else {
            return null;
        }
    }
}