<?php

enum Day {
  case monday;
  case tuesday;
  case wednesday;
  case thursday;
  case friday;
  case saturday;
  case sunday;

}

class OpeningHour {
  private int $openingHourId;
  private Day $day;
  private DateTime $openingTime;
  private DateTime $closingTime;
  private bool $isCurrent;
  private Venue $venueId;

  public function __construct (int $openingHourId, Day $day, DateTime $openingTime, DateTime $closingTime, bool $isCurrent, Venue $venueId) {
    $this->$openingHourId = $openingHourId;
    $this->$day = $day;
    $this->$openingTime = $openingTime;
    $this->$closingTime = $closingTime;
    $this->$isCurrent = $isCurrent;
    $this->$venueId = $venueId;
  }

  public function getOpeningHourId():int {
    return $this->getOpeningHourId;
  }

  public function getDay(): Day {
    return $this->day;
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

  public function getVenueId(): Venue {
    return $this->venueId;
  }

  public function setOpeningHourId(int $openingHourId): void {
    $this->getOpeningHourId = $openingHourId;
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