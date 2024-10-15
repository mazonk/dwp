<?php
include_once "src/model/repositories/NewsRepository.php";

class NewsController {
    private NewsRepository $newsRepository;

    public function __construct() {
        $this->newsRepository = new NewsRepository();
    }

    /**
     * Retrieves all news items from the database.
     * 
     * If an optional id parameter is given, this method will only return the news item with that id.
     * 
     * @param int|null $id The id of the news item to retrieve. If null, all news items are retrieved.
     * 
     * @return array An array of News objects. If $id is given, the array will contain only one News object.
     * 
     * @throws PDOException If the database query fails
     */
    public function getNews($id = null) {
        if ($id) {
            return $this->newsRepository->get($id);
        } else {
            return $this->newsRepository->get();
        }
    }
}
?>
