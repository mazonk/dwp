<?php

enum Day {
  case Monday;
  case Tuesday;
  case Wednesday;
  case Thursday;
  case Friday;
  case Saturday;
  case Sunday;

}

class OpeningHour {
  private int $openingHourId;
  private Day $day;
  private DateTime $openingTime;
  private DateTime $closingTime;
  private bool $isCurrent;

  public function __construct (int $openingHourId, Day $day, DateTime $openingTime, DateTime $closingTime, bool $isCurrent) {
    $this->openingHourId = $openingHourId;
    $this->day = $day;
    $this->openingTime = $openingTime;
    $this->closingTime = $closingTime;
    $this->isCurrent = $isCurrent;
  }

  public function getOpeningHourId():int {
    return $this->openingHourId;
  }

  public function getDay(): string {
    return $this->day->name; // Return the name of the enum (ex. Monday)
  }

  public function getOpeningTime(): DateTime {
    return $this->openingTime;
  }

  public function getClosingTime(): DateTime {
    return $this->closingTime;
  }

  public function getIsCurrent(): bool {
    return $this->isCurrent;
  }

  public function setOpeningHourId(int $openingHourId): void {
    $this->openingHourId = $openingHourId;
  }

  public function setDay(Day $day): void {
    $this->day = $day;
  }

  public function setOpeningTime(DateTime $openingTime): void {
    $this->openingTime = $openingTime;
  }

  public function setClosingTime(DateTime $closingTime): void {
    $this->closingTime = $closingTime;
  }

  public function setIsCurrent(bool $isCurrent): void {
    $this->isCurrent = $isCurrent;
  }
}
?>