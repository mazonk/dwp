<?php
include_once "src/model/services/NewsService.php";

class NewsController {
    private NewsService $newsService;

    public function __construct() {
        $this->newsService = new NewsService();
    }

    public function getNews($id = null): array {
        return $this->newsService->getNews();
    }

    public function getNewsById($id): News {
        return $this->newsService->getNewsById($id);
    }
}
?>
