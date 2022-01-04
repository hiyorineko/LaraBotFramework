<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Location {
    public readonly string $title;
    public readonly string $address;
    public readonly float $latitude;
    public readonly float $longitude;

    /**
     * @param string $title
     * @param string $address
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(string $title, string $address, float $latitude, float $longitude)
    {
        $this->title = $title;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
