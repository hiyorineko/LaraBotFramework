<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Event {
    public readonly string $sourceType;
    public readonly string $userId;
    public readonly ?string $groupId;
    public readonly ?string $roomId;
    public readonly int $timestamp;
    public readonly ?Message $message;

    /**
     * @param string $sourceType
     * @param string $userId
     * @param ?string $groupId
     * @param ?string $roomId
     * @param int $timestamp
     * @param ?Message $message
     */
    public function __construct(string $sourceType, string $userId, ?string $groupId, ?string $roomId, int $timestamp, ?Message $message)
    {
        $this->sourceType = $sourceType;
        $this->userId = $userId;
        $this->groupId = $groupId;
        $this->roomId = $roomId;
        $this->timestamp = $timestamp;
        $this->message = $message;
    }
}
