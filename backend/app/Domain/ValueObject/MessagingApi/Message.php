<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\MessagingApi;

class Message {
    public readonly string $replyToken;
    public readonly ?Text $text;
    public readonly ?Image $image;
    public readonly ?Video $video;
    public readonly ?Audio $audio;
    public readonly ?File $file;
    public readonly ?Location $location;
    public readonly ?Sticker $sticker;

    /**
     * @param string $replyToken
     * @param ?Text $text
     * @param ?Image $image
     * @param ?Video $video
     * @param ?Audio $audio
     * @param ?File $file
     * @param ?Location $location
     * @param ?Sticker $sticker
     */
    public function __construct(string $replyToken, ?Text $text, ?Image $image, ?Video $video, ?Audio $audio, ?File $file, ?Location $location, ?Sticker $sticker)
    {
        $this->replyToken = $replyToken;
        $this->text = $text;
        $this->image = $image;
        $this->video = $video;
        $this->audio = $audio;
        $this->file = $file;
        $this->location = $location;
        $this->sticker = $sticker;
    }
}
