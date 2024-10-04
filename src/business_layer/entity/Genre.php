<?php

class Genre {
    private int $genreId;
    private string $name;

    public function __construct(int $genreId, string $name) {
        $this->genreId = $genreId;
        $this->name = $name;
    }

    public function getGenreId(): int {
        return $this->genreId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}
?>