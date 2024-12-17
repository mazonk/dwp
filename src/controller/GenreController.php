<?php
include_once "src/model/services/GenreService.php";

class GenreController {
    private GenreService $genreService;

    public function __construct() {
        $this->genreService = new GenreService();
    }

    public function getAllGenres(): array {
        return $this->genreService->getAllGenres();
    }

    public function getAllGenresByMovieId(int $movieId): array {
        return $this->genreService->getAllGenresByMovieId($movieId);
    }

    public function addGenresToMovie(int $movieId, array $genreIds): array {
        $errors = $this->genreService->addGenresToMovie($movieId, $genreIds);
        if (!isset($errors['error'])) {
            return ['success' => true];
        } else {
            return $errors;
        }
    }
}