<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class File {
    public readonly int $fileSize;
    public readonly string $fileName;

    /**
     * @param int $fileSize
     * @param string $fileName
     */
    public function __construct(int $fileSize, string $fileName)
    {
        $this->fileSize = $fileSize;
        $this->fileName = $fileName;
    }
}
