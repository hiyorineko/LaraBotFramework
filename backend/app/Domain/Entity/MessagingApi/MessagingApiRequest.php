<?php
namespace App\Domain\Entity\MessagingApi;

use App\Domain\Entity\BotApiRequest;
use App\Domain\ValueObject\MessagingApi\Audio;
use App\Domain\ValueObject\MessagingApi\Event;
use App\Domain\ValueObject\MessagingApi\File;
use App\Domain\ValueObject\MessagingApi\Image;
use App\Domain\ValueObject\MessagingApi\Location;
use App\Domain\ValueObject\MessagingApi\Message;
use App\Domain\ValueObject\MessagingApi\Sticker;
use App\Domain\ValueObject\MessagingApi\Text;
use App\Domain\ValueObject\MessagingApi\Video;
use Illuminate\Support\Facades\Log;

class MessagingApiRequest implements BotApiRequest {

    /**
     * @var Event[]
     */
    private readonly array $events;

    public function __construct(array $requestBody)
    {
        $events = array();
        foreach ($requestBody['events'] as $eventInput) {
            $event = new Event(
                $eventInput['source']['type'],
                $eventInput['source']['userId'],
                $eventInput['source']['groupId'] ?? null,
                $eventInput['source']['roomId'] ?? null,
                $eventInput['timestamp'],
                $this->createMessage($eventInput) ?? null,
            );
            $events[] = $event;
        }
        $this->events = $events;
    }


    private function createMessage(array $eventInput) : Message
    {
        return new Message(
            $eventInput['replyToken'],
            $this->createText($eventInput['message']),
            $this->createImage($eventInput['message']),
            $this->createVideo($eventInput['message']),
            $this->createAudio($eventInput['message']),
            $this->createFile($eventInput['message']),
            $this->createLocation($eventInput['message']),
            $this->createSticker($eventInput['message']),
        );
    }

    private function createText(mixed $message) : ?Text
    {
        if ($message['type'] !== 'text') {
            return null;
        }

        return new Text(
            $message['text'],
            $message['emojis'] ?? null,
            $message['mention'] ?? null,
        );
    }

    private function createImage(mixed $message) : ?Image
    {
        if ($message['type'] !== 'image') {
            return null;
        }

        return new Image(
            isset($message['imageSet']) ? $message['imageSet']['id'] : null,
            isset($message['imageSet']) ? $message['imageSet']['index'] : 0,
            isset($message['imageSet']) ? $message['imageSet']['total'] : 0,
            $message['contentProvider']['type'],
            $message['contentProvider']['originalContentUrl'] ?? '',
            $message['contentProvider']['previewImageUrl'] ?? '',
        );
    }

    private function createVideo(mixed $message) : ?Video
    {
        if ($message['type'] !== 'video') {
            return null;
        }

        return new Video(
            $message['duration'],
            $message['contentProvider']['type'],
            $message['contentProvider']['originalContentUrl'] ?? '',
            $message['contentProvider']['previewImageUrl'] ?? '',
        );
    }

    private function createAudio(mixed $message) : ?Audio
    {
        if ($message['type'] !== 'audio') {
            return null;
        }

        return new Audio(
            $message['duration'],
            $message['contentProvider']['type'],
            $message['contentProvider']['originalContentUrl'] ?? '',
        );
    }

    private function createFile(mixed $message) : ?File
    {
        if ($message['type'] !== 'file') {
            return null;
        }

        return new File(
            $message['fileSize'],
            $message['fileName'],
        );
    }

    private function createLocation(mixed $message) : ?Location
    {
        if ($message['type'] !== 'location') {
            return null;
        }

        return new Location(
            $message['title'],
            $message['address'],
            $message['latitude'],
            $message['longitude'],
        );
    }

    private function createSticker(mixed $message) : ?Sticker
    {
        if ($message['type'] !== 'sticker') {
            return null;
        }

        return new Sticker(
            $message['packageId'],
            $message['stickerId'],
            $message['stickerResourceType'],
            $message['keywords'] ?? null,
            $message['text'] ?? null,
        );
    }

    public function getMessageText() : string
    {
        foreach ($this->events as $event) {
            return $event->message->text->text ?? '';
        }
        return '';
    }

    public function getReplyToken() : string
    {
        foreach ($this->events as $event) {
            return $event->message->replyToken ?? '';
        }
        return '';
    }
}
