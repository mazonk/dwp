<?php

class News {
  private int $newsId;
  private string $imageURL;
  private string $header;
  private string $content;

  public function __construct (int $newsId, string $imageURL, string $header, string $content) {
    $this->newsId = $newsId;
    $this->imageURL = $imageURL;
    $this->header = $header;
    $this->content = $content;
  }

  public function getNewsId(): int {
    return $this->newsId;
  }

  public function getImageURL(): string {
    return $this->imageURL;
  }

  public function getHeader(): string {
    return $this->header;
  }

  public function getContent(): string {
    return $this->content;
  }

  public function setNewsId(int $newsId): void {
    $this->newsId = $newsId;
  }

  public function setImageURL(string $imageURL): void {
    $this->imageURL = $imageURL;
  }

  public function setHeader(string $header): void {
    $this->header = $header;
  }

  public function setContent(string $content): void {
    $this->content = $content;
  }
}
?>