<?php
include_once "src/model/repositories/NewsRepository.php";

class NewsController {
    private NewsRepository $newsRepository;

    public function __construct() {
        $this->newsRepository = new NewsRepository();
    }

    public function getNews($id = null): array {
        return $this->newsRepository->getAll();
    }

    public function getNewsById($id): News {
        return $this->newsRepository->get($id);
    }
}
?>
