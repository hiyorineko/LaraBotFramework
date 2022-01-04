<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Image {
    public readonly string $imageSetId;
    public readonly int $imageSetIndex;
    public readonly int $imageSetTotal;
    public readonly string $type;
    public readonly string $originalContentUrl;
    public readonly string $previewImageUrl;

    /**
     * @param string $imageSetId
     * @param int $imageSetIndex
     * @param int $imageSetTotal
     * @param string $type
     * @param string $originalContentUrl
     * @param string $previewImageUrl
     */
    public function __construct(string $imageSetId, int $imageSetIndex, int $imageSetTotal, string $type, string $originalContentUrl, string $previewImageUrl)
    {
        $this->imageSetId = $imageSetId;
        $this->imageSetIndex = $imageSetIndex;
        $this->imageSetTotal = $imageSetTotal;
        $this->type = $type;
        $this->originalContentUrl = $originalContentUrl;
        $this->previewImageUrl = $previewImageUrl;
    }


}
