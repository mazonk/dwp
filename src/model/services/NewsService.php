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

    public function addNews(array $newsData): array {
        $errors = [];

        // Validate the form data inputs
        $this->validateFormInputs($newsData, $errors);

        // If there are no errors, add the news
        if (count($errors) == 0) {
            try {
                $this->newsRepository->addNews($newsData);
                return ['success' => true];
            } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } 
        // If there are validation errors, return them
        else {
            return $errors;
        }
    }

    public function editNews(array $newsData): array {
        $errors = [];

        // Validate the form data inputs
        $this->validateFormInputs($newsData, $errors);

        // If there are no errors, edit the news
        if (count($errors) == 0) {
            try {
                $this->newsRepository->editNews($newsData);
                return ['success' => true];
            } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
        }
        // If there are validation errors, return them
        else {
            return $errors;
        }
    }

    private function validateFormInputs(array $newsData, array &$errors): void {
        // Define regexes for validation
        $regex = "/^[a-zA-Z0-9áéíóöúüűæøåÆØÅ\s\-\.,;:'\"!?]+$/";
    
        // Perform checks
        if (empty($newsData['header']) || empty($newsData['content'])) {
            $errors['general'] = "All fields are required.";
        }
        if (!preg_match($regex, $newsData['header'])) {
            $errors['header'] = "Header must only contain contain letters, numbers, and basic punctuation.";
        }
        if (strlen($newsData['header']) < 10) {
            $errors['header'] = "Header must be at least 10 characters long.";
        }
        if(strlen($newsData['header']) > 255) {
          $errors['header'] = "Header can't be longer than 50 characters.";
        }
        if (!preg_match($regex, $newsData['content'])) {
            $errors['content'] = "Content must only contain letters, numbers, and basic punctuation.";
        }
        if(strlen($newsData['content']) < 25) {
            $errors['content'] = "Content must be at least 25 characters long.";
        }
        if(strlen($newsData['content']) > 5000) {
            $errors['content'] = "Content can't be longer than 5000 characters.";
        }
    
    }
}