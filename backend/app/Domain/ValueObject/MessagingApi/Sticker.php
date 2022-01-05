<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Sticker {
    public readonly string $packageId;
    public readonly string $stickerId;
    public readonly string $stickerResourceType;
    public readonly array $keywords;
    public readonly ?string $text;

    /**
     * @param string $packageId
     * @param string $stickerId
     * @param string $stickerResourceType
     * @param array $keywords
     * @param ?string $text
     */
    public function __construct(string $packageId, string $stickerId, string $stickerResourceType, array $keywords, ?string $text)
    {
        $this->packageId = $packageId;
        $this->stickerId = $stickerId;
        $this->stickerResourceType = $stickerResourceType;
        $this->keywords = $keywords;
        $this->text = $text;
    }
}
