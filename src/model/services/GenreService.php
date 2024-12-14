<?php
include_once "src/model/repositories/GenreRepository.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Genre.php";
class GenreService {
    private GenreRepository $genreRepository;
    public function __construct() {
        $this->genreRepository = new GenreRepository();
    }

    public function getAllGenresByMovieId(int $movieId): array {
        try {
            $result = $this->genreRepository->getAllGenresByMovieId($movieId);
            $genres = [];
            foreach ($result as $genre) {
                $genres[] = new Genre($genre['genreId'], $genre['name']);
            }
        } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
            return $genres;
        }
}