<?php

class Movie
{
    private int $movieId;
    private string $title;
    private ?string $description; // ? = Nullable field
    private ?int $duration;
    private ?string $language;
    private ?DateTime $releaseDate;
    private ?string $posterURL;
    private ?string $promoURL;
    private ?float $rating;
    private ?string $trailerURL;

    public function __construct(
        int $movieId,
        string $title,
        string $description = null,
        int $duration = null,
        string $language = null,
        string $releaseDate = null,
        string $posterURL = null,
        string $promoURL = null,
        float $rating = null,
        string $trailerURL = null
    ) {
        $this->movieId = $movieId;
        $this->title = $title;
        $this->description = $description;
        $this->duration = $duration;
        $this->language = $language;
        $this->releaseDate = $releaseDate ? new DateTime($releaseDate) : null; // Nullable DateTime
        $this->posterURL = $posterURL;
        $this->promoURL = $promoURL;
        $this->rating = $rating;
        $this->trailerURL = $trailerURL;
    }

    // Getters
    public function getMovieId(): int {
        return $this->movieId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getDuration(): ?int {
        return $this->duration;
    }

    public function getLanguage(): ?string {
        return $this->language;
    }

    public function getReleaseDate(): ?DateTime {
        return $this->releaseDate;
    }

    public function getPosterURL(): ?string {
        return $this->posterURL;
    }

    public function getPromoURL(): ?string {
        return $this->promoURL;
    }

    public function getRating(): ?float {
        return $this->rating;
    }

    public function getTrailerURL(): ?string {
        return $this->trailerURL;
    }

    // Setters
    public function setMovieId(int $movieId): void {
        $this->movieId = $movieId;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setDuration(?int $duration): void {
        $this->duration = $duration;
    }

    public function setLanguage(?string $language): void {
        $this->language = $language;
    }

    public function setReleaseDate(?string $releaseDate): void {
        $this->releaseDate = $releaseDate ? new DateTime($releaseDate) : null;
    }

    public function setPosterURL(?string $posterURL): void {
        $this->posterURL = $posterURL;
    }

    public function setPromoURL(?string $promoURL): void {
        $this->promoURL = $promoURL;
    }

    public function setRating(?float $rating): void {
        $this->rating = $rating;
    }

    public function setTrailerURL(?string $trailerURL): void {
        $this->trailerURL = $trailerURL;
    }
}
?>
