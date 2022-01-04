<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Text {
    public readonly string $text;
    public readonly ?array $emojis;
    public readonly ?array $mention;

    /**
     * @param string $text
     * @param ?array $emojis
     * @param ?array $mention
     */
    public function __construct(string $text, ?array $emojis, ?array $mention)
    {
        $this->text = $text;
        $this->emojis = $emojis;
        $this->mention = $mention;
    }
}
