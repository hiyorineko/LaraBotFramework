<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Video {
    public readonly int $duration;
    public readonly string $type;
    public readonly string $originalContentUrl;
    public readonly string $previewImageUrl;

    /**
     * @param int $duration
     * @param string $type
     * @param string $originalContentUrl
     * @param string $previewImageUrl
     */
    public function __construct(int $duration, string $type, string $originalContentUrl, string $previewImageUrl)
    {
        $this->duration = $duration;
        $this->type = $type;
        $this->originalContentUrl = $originalContentUrl;
        $this->previewImageUrl = $previewImageUrl;
    }
}
