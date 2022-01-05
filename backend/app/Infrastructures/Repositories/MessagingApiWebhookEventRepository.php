<?php
namespace App\Infrastructures\Repositories;

use App\Domain\Entity\BotApiRequest;
use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Infrastructures\EloquentModels\MessagingApiAccountLink;
use App\Infrastructures\EloquentModels\MessagingApiBeacon;
use App\Infrastructures\EloquentModels\MessagingApiFollow;
use App\Infrastructures\EloquentModels\MessagingApiJoin;
use App\Infrastructures\EloquentModels\MessagingApiLeave;
use App\Infrastructures\EloquentModels\MessagingApiMassage;
use App\Infrastructures\EloquentModels\MessagingApiMassageAudio;
use App\Infrastructures\EloquentModels\MessagingApiMassageFile;
use App\Infrastructures\EloquentModels\MessagingApiMassageImage;
use App\Infrastructures\EloquentModels\MessagingApiMassageLocation;
use App\Infrastructures\EloquentModels\MessagingApiMassageSticker;
use App\Infrastructures\EloquentModels\MessagingApiMassageText;
use App\Infrastructures\EloquentModels\MessagingApiMassageVideo;
use App\Infrastructures\EloquentModels\MessagingApiMemberJoined;
use App\Infrastructures\EloquentModels\MessagingApiMemberLeft;
use App\Infrastructures\EloquentModels\MessagingApiPostback;
use App\Infrastructures\EloquentModels\MessagingApiThingsLink;
use App\Infrastructures\EloquentModels\MessagingApiThingsScenarioResult;
use App\Infrastructures\EloquentModels\MessagingApiThingsUnlink;
use App\Infrastructures\EloquentModels\MessagingApiUnfollow;
use App\Infrastructures\EloquentModels\MessagingApiUnsend;
use App\Infrastructures\EloquentModels\MessagingApiVideoPlayComplete;
use App\Infrastructures\EloquentModels\MessagingApiWebhookEvent;
use Illuminate\Support\Facades\DB;

class MessagingApiWebhookEventRepository implements Repository
{
    public function getRequestEntity(array $requestBody) : BotApiRequest
    {
        return new MessagingApiRequest($requestBody);
    }

    public function storeRequest(array $requestBody) : void
    {
        $this->createEvents($requestBody);
    }

    /**
     * @param array $requestBody
     * @return MessagingApiWebhookEvent[]
     */
    private function createEvents(array $requestBody) : array
    {
        DB::beginTransaction();
        $events = [];
        foreach ($requestBody['events'] as $eventInput) {
            $event = MessagingApiWebhookEvent::create([
                'destination' => $requestBody['destination'],
                'mode' => $eventInput['mode'],
                'sourceType'=> $eventInput['source']['type'],
                'userId' => $eventInput['source']['userId'],
                'groupId' => $eventInput['source']['groupId'] ?? null,
                'roomId' => $eventInput['source']['roomId'] ?? null,
                'timestamp' => $eventInput['timestamp'],
            ]);
            $this->createEventDetail($event->id, $eventInput);
            $events[] = $event;
        }
        DB::commit();
        return $events;
    }

    private function createEventDetail($eventId, $eventInput) {
        if ($eventInput['type'] === 'message') {
            $this->createEventMessage($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unsend') {
            $this->createEventUnsend($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'follow') {
            $this->createEventFollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unfollow') {
            $this->createEventUnfollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'join') {
            $this->createEventJoin($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'leave') {
            $this->createEventLeave($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberJoined') {
            $this->createEventMemberJoined($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberLeft') {
            $this->createEventMemberLeft($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'postback') {
            $this->createEventPostback($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'videoPlayComplete') {
            $this->createEventVideoPlayComplete($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'beacon') {
            $this->createEventBeacon($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'accountLink') {
            $this->createEventAccountLink($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'things') {
            $this->createEventThings($eventId, $eventInput);
        }
    }

    private function createEventMessage($eventId, $eventInput)
    {

        $message = MessagingApiMassage::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken']
        ]);

        if ($eventInput['message']['type'] === 'text') {
            $this->createEventMessageText($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'image') {
            $this->createEventMessageImage($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'video') {
            $this->createEventMessageVideo($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'audio') {
            $this->createEventMessageAudio($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'file') {
            $this->createEventMessageFile($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'location') {
            $this->createEventMessageLocation($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'sticker') {
            $this->createEventMessageSticker($message->id, $eventInput['message']);
        }

    }

    private function createEventMessageText($messageId, $messageInput)
    {
        MessagingApiMassageText::create([
            'messageId' => $messageId,
            'text' => $messageInput['text'],
            'emojis' => $messageInput['emojis'] ?? null,
            'mention' => $messageInput['mention'] ?? null,
        ]);
    }

    private function createEventMessageImage($messageId, $messageInput)
    {
        MessagingApiMassageImage::create([
            'messageId' => $messageId,
            'imageSetId' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['id'] : null,
            'imageSetIndex' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['index'] : 0,
            'imageSetTotal' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['total'] : 0,
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['originalContentUrl'] ?? '',
            'previewImageUrl' => $messageInput['contentProvider']['previewImageUrl'] ?? '',
        ]);
    }

    private function createEventMessageVideo($messageId, $messageInput)
    {
        MessagingApiMassageVideo::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['originalContentUrl'] ?? '',
            'previewImageUrl' => $messageInput['contentProvider']['previewImageUrl'] ?? '',
        ]);
    }

    private function createEventMessageAudio($messageId, $messageInput)
    {
        MessagingApiMassageAudio::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' =>  $messageInput['contentProvider']['originalContentUrl'] ?? '',
        ]);
    }

    private function createEventMessageFile($messageId, $messageInput)
    {
        MessagingApiMassageFile::create([
            'messageId' => $messageId,
            'fileName' => $messageInput['fileName'],
            'fileSize' => $messageInput['fileSize'],
        ]);
    }

    private function createEventMessageLocation($messageId, $messageInput)
    {
        MessagingApiMassageLocation::create([
            'messageId' => $messageId,
            'title' => $messageInput['title'],
            'address' => $messageInput['address'],
            'latitude' => $messageInput['latitude'],
            'longitude' => $messageInput['longitude'],
        ]);
    }

    private function createEventMessageSticker($messageId, $messageInput)
    {
        MessagingApiMassageSticker::create([
            'messageId' => $messageId,
            'packageId' => $messageInput['packageId'],
            'stickerId' => $messageInput['stickerId'],
            'stickerResourceType' => $messageInput['stickerResourceType'],
            'keywords' => $messageInput['keywords'] ?? null,
            'text' => $messageInput['text'] ?? null,
        ]);
    }

    private function createEventUnsend($eventId, $eventInput)
    {
        MessagingApiUnsend::create([
            'webhookEventId' => $eventId,
            'messageId' => $eventInput['unsend']['messageId']
        ]);
    }

    private function createEventFollow($eventId, $eventInput)
    {
        MessagingApiFollow::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function createEventUnfollow($eventId, $eventInput)
    {
        MessagingApiUnfollow::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function createEventJoin($eventId, $eventInput)
    {
        MessagingApiJoin::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function createEventLeave($eventId, $eventInput)
    {
        MessagingApiLeave::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function createEventMemberJoined($eventId, $eventInput)
    {
        MessagingApiMemberJoined::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function createEventMemberLeft($eventId, $eventInput)
    {
        MessagingApiMemberLeft::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function createEventPostback($eventId, $eventInput)
    {
        MessagingApiPostback::create([
            'webhookEventId' => $eventId,
            'data' => $eventInput['postback']['data'],
            'params' => $eventInput['postback']['params'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function createEventVideoPlayComplete($eventId, $eventInput)
    {
        MessagingApiVideoPlayComplete::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'trackingId' => $eventInput['videoPlayComplete']['trackingId'],
        ]);
    }

    private function createEventBeacon($eventId, $eventInput)
    {
        MessagingApiBeacon::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'beaconHwid' => $eventInput['beacon']['hwid'],
            'beaconType' => $eventInput['beacon']['type'],
            'beaconDm' => $eventInput['beacon']['dm'] ?? null,
        ]);
    }

    private function createEventAccountLink($eventId, $eventInput)
    {
        MessagingApiAccountLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'link' => $eventInput['link'],
        ]);
    }

    private function createEventThings($eventId, $eventInput)
    {
        if ($eventInput['things']['type'] === 'link') {
            $this->createEventThingsLink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'unlink') {
            $this->createEventThingsUnlink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'scenarioResult') {
            $this->createEventThingsScenarioResult($eventId, $eventInput);
        }
    }

    private function createEventThingsLink($eventId, $eventInput)
    {
        MessagingApiThingsLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function createEventThingsUnlink($eventId, $eventInput)
    {
        MessagingApiThingsUnlink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function createEventThingsScenarioResult($eventId, $eventInput)
    {
        MessagingApiThingsScenarioResult::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId'],
            'thingsResultScenarioId' => $eventInput['things']['result']['scenarioId'],
            'thingsResultRevision' => $eventInput['things']['result']['revision'],
            'thingsResultStartTime' => $eventInput['things']['result']['startTime'],
            'thingsResultEndTime' => $eventInput['things']['result']['endTime'],
            'thingsResultResultCode' => $eventInput['things']['result']['resultCode'],
            'thingsResultActionResults' => $eventInput['things']['result']['actionResults'],
            'thingsResultBleNotificationPayload' => $eventInput['things']['result']['bleNotificationPayload'],
            'thingsResultErrorReason' => $eventInput['things']['result']['errorReason'] ?? null,
        ]);
    }

}
