<?php
include_once "src/model/repository/ShowingRepository.php";

class ShowingController {
    private $showingRepository;

    public function __construct() {
        $this->showingRepository = new ShowingRepository();
    }

    public function getAllShowings() {
        return $this->showingRepository->getAllShowings();
    }
}
