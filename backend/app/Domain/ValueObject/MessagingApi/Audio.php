<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Audio {
    public readonly int $duration;
    public readonly string $type;
    public readonly string $originalContentUrl;

    /**
     * @param int $duration
     * @param string $type
     * @param string $originalContentUrl
     */
    public function __construct(int $duration, string $type, string $originalContentUrl)
    {
        $this->duration = $duration;
        $this->type = $type;
        $this->originalContentUrl = $originalContentUrl;
    }
}
