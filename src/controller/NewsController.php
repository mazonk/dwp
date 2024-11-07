<?php
include_once "src/model/services/NewsService.php";

class NewsController {
    private NewsService $newsService;

    public function __construct() {
        $this->newsService = new NewsService();
    }

    public function getAllNews(): array {
        $news = $this->newsService->getAllNews();

        if (isset($news['error']) && $news['error']) {
            return ['errorMessage' => $news['message']];
        }

        return $news;
    }

    public function getNewsById(int $id): array|News {
        $news = $this->newsService->getNewsById(htmlspecialchars($id));

        if (is_array($news) && isset($news['error']) && $news['error']) {
            return ['errorMessage' => $news['message']];
        }

        return $news;
    }

    public function addNews(array $newsData): array {
        $errors = $this->newsService->addNews($newsData);

        // Check if there are any validation errors
        if(count($errors) == 0) {
            // Check if there are any errors from adding the news
            if (isset($errors['error']) && $errors['error']) {
                return ['errorMessage' => $errors['message']];
            }
            return ['success' => true];
        } else {
            return $errors;
        }
    }
}
