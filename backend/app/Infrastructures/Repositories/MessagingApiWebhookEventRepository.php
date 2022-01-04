<?php
namespace App\Infrastructures\Repositories;

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

    /**
     * @param mixed $requestBody
     * @return MessagingApiRequest
     */
    public function getRequestEntity(mixed $requestBody)
    {
        $this->createEvents($requestBody);
        return new MessagingApiRequest($requestBody);
    }

    /**
     * リクエストをオブジェクトにマッピング
     * @param mixed $requestBody
     * @return MessagingApiWebhookEvent[]
     */
    public function createEvents(mixed $requestBody): array
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
            $this->setEventDetail($event->id, $eventInput);
            $events[] = $event;
        }
        DB::commit();
        return $events;
    }

    private function setEventDetail($eventId, $eventInput) {
        if ($eventInput['type'] === 'message') {
            $this->setEventMessage($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unsend') {
            $this->setEventUnsend($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'follow') {
            $this->setEventFollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unfollow') {
            $this->setEventUnfollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'join') {
            $this->setEventJoin($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'leave') {
            $this->setEventLeave($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberJoined') {
            $this->setEventMemberJoined($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberLeft') {
            $this->setEventMemberLeft($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'postback') {
            $this->setEventPostback($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'videoPlayComplete') {
            $this->setEventVideoPlayComplete($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'beacon') {
            $this->setEventBeacon($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'accountLink') {
            $this->setEventAccountLink($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'things') {
            $this->setEventThings($eventId, $eventInput);
        }
    }

    private function setEventMessage($eventId, $eventInput)
    {

        $message = MessagingApiMassage::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken']
        ]);

        if ($eventInput['message']['type'] === 'text') {
            $this->setEventMessageText($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'image') {
            $this->setEventMessageImage($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'video') {
            $this->setEventMessageVideo($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'audio') {
            $this->setEventMessageAudio($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'file') {
            $this->setEventMessageFile($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'location') {
            $this->setEventMessageLocation($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'sticker') {
            $this->setEventMessageSticker($message->id, $eventInput['message']);
        }

    }

    private function setEventMessageText($messageId, $messageInput)
    {
        MessagingApiMassageText::create([
            'messageId' => $messageId,
            'text' => $messageInput['text'],
            'emojis' => $messageInput['emojis'] ?? null,
            'mention' => $messageInput['mention'] ?? null,
        ]);
    }

    private function setEventMessageImage($messageId, $messageInput)
    {
        $messageImage = MessagingApiMassageImage::create([
            'messageId' => $messageId,
            'imageSetId' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['id'] : null,
            'imageSetIndex' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['index'] : 0,
            'imageSetTotal' => isset($messageInput['imageSet']) ? $messageInput['imageSet']['total'] : 0,
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['originalContentUrl'] ?? '',
            'previewImageUrl' => $messageInput['contentProvider']['previewImageUrl'] ?? '',
        ]);
    }

    private function setEventMessageVideo($messageId, $messageInput)
    {
        $messageVideo = MessagingApiMassageVideo::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['originalContentUrl'] ?? '',
            'previewImageUrl' => $messageInput['contentProvider']['previewImageUrl'] ?? '',
        ]);
    }

    private function setEventMessageAudio($messageId, $messageInput)
    {
        $messageAudio = MessagingApiMassageAudio::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' =>  $messageInput['contentProvider']['originalContentUrl'] ?? '',
        ]);
    }

    private function setEventMessageFile($messageId, $messageInput)
    {
        $messageFile = MessagingApiMassageFile::create([
            'messageId' => $messageId,
            'fileName' => $messageInput['fileName'],
            'fileSize' => $messageInput['fileSize'],
        ]);
    }

    private function setEventMessageLocation($messageId, $messageInput)
    {
        MessagingApiMassageLocation::create([
            'messageId' => $messageId,
            'title' => $messageInput['title'],
            'address' => $messageInput['address'],
            'latitude' => $messageInput['latitude'],
            'longitude' => $messageInput['longitude'],
        ]);
    }

    private function setEventMessageSticker($messageId, $messageInput)
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

    private function setEventUnsend($eventId, $eventInput)
    {
        MessagingApiUnsend::create([
            'webhookEventId' => $eventId,
            'messageId' => $eventInput['unsend']['messageId']
        ]);
    }

    private function setEventFollow($eventId, $eventInput)
    {
        MessagingApiFollow::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventUnfollow($eventId, $eventInput)
    {
        MessagingApiUnfollow::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function setEventJoin($eventId, $eventInput)
    {
        MessagingApiJoin::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventLeave($eventId, $eventInput)
    {
        MessagingApiLeave::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function setEventMemberJoined($eventId, $eventInput)
    {
        MessagingApiMemberJoined::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventMemberLeft($eventId, $eventInput)
    {
        MessagingApiMemberLeft::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventPostback($eventId, $eventInput)
    {
        MessagingApiPostback::create([
            'webhookEventId' => $eventId,
            'data' => $eventInput['postback']['data'],
            'params' => $eventInput['postback']['params'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventVideoPlayComplete($eventId, $eventInput)
    {
        MessagingApiVideoPlayComplete::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'trackingId' => $eventInput['videoPlayComplete']['trackingId'],
        ]);
    }

    private function setEventBeacon($eventId, $eventInput)
    {
        MessagingApiBeacon::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'beaconHwid' => $eventInput['beacon']['hwid'],
            'beaconType' => $eventInput['beacon']['type'],
            'beaconDm' => $eventInput['beacon']['dm'] ?? null,
        ]);
    }

    private function setEventAccountLink($eventId, $eventInput)
    {
        MessagingApiAccountLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'link' => $eventInput['link'],
        ]);
    }

    private function setEventThings($eventId, $eventInput)
    {
        if ($eventInput['things']['type'] === 'link') {
            $this->setEventThingsLink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'unlink') {
            $this->setEventThingsUnlink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'scenarioResult') {
            $this->setEventThingsScenarioResult($eventId, $eventInput);
        }
    }

    private function setEventThingsLink($eventId, $eventInput)
    {
        MessagingApiThingsLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function setEventThingsUnlink($eventId, $eventInput)
    {
        MessagingApiThingsUnlink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function setEventThingsScenarioResult($eventId, $eventInput)
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
