<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructures\MessagingApi;
use App\Models\MessagingApiAccountLink;
use App\Models\MessagingApiBeacon;
use App\Models\MessagingApiFollow;
use App\Models\MessagingApiJoin;
use App\Models\MessagingApiLeave;
use App\Models\MessagingApiMassage;
use App\Models\MessagingApiMassageAudio;
use App\Models\MessagingApiMassageFile;
use App\Models\MessagingApiMassageImage;
use App\Models\MessagingApiMassageLocation;
use App\Models\MessagingApiMassageSticker;
use App\Models\MessagingApiMassageText;
use App\Models\MessagingApiMassageVideo;
use App\Models\MessagingApiMemberJoined;
use App\Models\MessagingApiMemberLeft;
use App\Models\MessagingApiPostback;
use App\Models\MessagingApiThingsLink;
use App\Models\MessagingApiThingsScenarioResult;
use App\Models\MessagingApiThingsUnlink;
use App\Models\MessagingApiUnfollow;
use App\Models\MessagingApiUnsend;
use App\Models\MessagingApiVideoPlayComplete;
use App\Models\MessagingApiWebhookEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessagingApiController extends Controller
{

    public function webhook(Request $request)
    {
        // Modelクラスにリクエストデータをマッピング
        $events = $this->createEvents($request->input());


        // 翻訳したRequestをUseCaseInteractに渡す


        // 渡すだけで終わりがいいかなControllerとしては


        //            1. getMessageObjectServiceでメッセージを取得
        //            2. メッセージの振る舞いを実行

        foreach ($request->get('events') as $event) {
            //$text = $event['message']['text'];
            //$replyToken = $event['replyToken'];
            //$userId = $event['source']['userId'];
            //MessagingApi::reply($replyToken, array(MessagingApi::createTextMessage($text)));
            //MessagingApi::push($userId, array(MessagingApi::createTextMessage("push")));
        }
    }

    /**
     * リクエストをオブジェクトにマッピング
     * @param $input
     * @return MessagingApiWebhookEvent[]
     */
    private function createEvents($input): array
    {
        DB::beginTransaction();
        $events = [];
        foreach ($input['events'] as $eventInput) {
            $event = MessagingApiWebhookEvent::create([
                'destination' => $input['destination'],
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
            $this->setEventDetailMessage($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unsend') {
            $this->setEventDetailUnsend($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'follow') {
            $this->setEventDetailFollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'unfollow') {
            $this->setEventDetailUnfollow($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'join') {
            $this->setEventDetailJoin($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'leave') {
            $this->setEventDetailLeave($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberJoined') {
            $this->setEventDetailMemberJoined($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'memberLeft') {
            $this->setEventDetailMemberLeft($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'postback') {
            $this->setEventDetailPostback($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'videoPlayComplete') {
            $this->setEventDetailVideoPlayComplete($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'beacon') {
            $this->setEventDetailBeacon($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'accountLink') {
            $this->setEventDetailAccountLink($eventId, $eventInput);
        } elseif ($eventInput['type'] === 'things') {
            $this->setEventDetailThings($eventId, $eventInput);
        }
    }

    private function setEventDetailMessage($eventId, $eventInput)
    {

        $message = MessagingApiMassage::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken']
        ]);

        if ($eventInput['message']['type'] === 'text') {
            $this->setEventDetailMessageText($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'image') {
            $this->setEventDetailMessageImage($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'video') {
            $this->setEventDetailMessageVideo($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'audio') {
            $this->setEventDetailMessageAudio($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'file') {
            $this->setEventDetailMessageFile($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'location') {
            $this->setEventDetailMessageLocation($message->id, $eventInput['message']);
        } elseif ($eventInput['message']['type'] === 'sticker') {
            $this->setEventDetailMessageSticker($message->id, $eventInput['message']);
        }

    }

    private function setEventDetailMessageText($messageId, $messageInput)
    {
        MessagingApiMassageText::create([
            'messageId' => $messageId,
            'text' => $messageInput['text'],
            'emojis' => $messageInput['emojis'] ?? null,
            'mention' => $messageInput['mention'] ?? null,
        ]);
    }

    private function setEventDetailMessageImage($messageId, $messageInput)
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

        // todo fileダウンロード処理
        $messageImage->path = '';
        $messageImage->fileName = '';
    }

    private function setEventDetailMessageVideo($messageId, $messageInput)
    {
        $messageVideo = MessagingApiMassageVideo::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['originalContentUrl'] ?? '',
            'previewImageUrl' => $messageInput['contentProvider']['previewImageUrl'] ?? '',
        ]);

        // todo fileダウンロード処理
        $messageVideo->path = '';
        $messageVideo->fileName = '';
    }

    private function setEventDetailMessageAudio($messageId, $messageInput)
    {
        $messageAudio = MessagingApiMassageAudio::create([
            'messageId' => $messageId,
            'duration' => $messageInput['duration'],
            'type' => $messageInput['contentProvider']['type'],
            'originalContentUrl' => $messageInput['contentProvider']['type'] === 'external' ? $messageInput['contentProvider']['originalContentUrl'] : '',
        ]);

        // todo fileダウンロード処理
        $messageAudio->path = '';
        $messageAudio->fileName = '';
    }

    private function setEventDetailMessageFile($messageId, $messageInput)
    {
        $messageFile = MessagingApiMassageFile::create([
            'messageId' => $messageId,
            'fileName' => $messageInput['fileName'],
            'fileSize' => $messageInput['fileSize'],
        ]);

        // todo fileダウンロード処理
        $messageFile->path = '';
        $messageFile->fileName = '';
    }

    private function setEventDetailMessageLocation($messageId, $messageInput)
    {
        MessagingApiMassageLocation::create([
            'messageId' => $messageId,
            'title' => $messageInput['title'],
            'address' => $messageInput['address'],
            'latitude' => $messageInput['latitude'],
            'longitude' => $messageInput['longitude'],
        ]);
    }

    private function setEventDetailMessageSticker($messageId, $messageInput)
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

    private function setEventDetailUnsend($eventId, $eventInput)
    {
        MessagingApiUnsend::create([
            'webhookEventId' => $eventId,
            'messageId' => $eventInput['unsend']['messageId']
        ]);
    }

    private function setEventDetailFollow($eventId, $eventInput)
    {
        MessagingApiFollow::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventDetailUnfollow($eventId, $eventInput)
    {
        MessagingApiUnfollow::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function setEventDetailJoin($eventId, $eventInput)
    {
        MessagingApiJoin::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventDetailLeave($eventId, $eventInput)
    {
        MessagingApiLeave::create([
            'webhookEventId' => $eventId,
        ]);
    }

    private function setEventDetailMemberJoined($eventId, $eventInput)
    {
        MessagingApiMemberJoined::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventDetailMemberLeft($eventId, $eventInput)
    {
        MessagingApiMemberLeft::create([
            'webhookEventId' => $eventId,
            'members' => $eventInput['joined']['members'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventDetailPostback($eventId, $eventInput)
    {
        MessagingApiPostback::create([
            'webhookEventId' => $eventId,
            'data' => $eventInput['postback']['data'],
            'params' => $eventInput['postback']['params'],
            'replyToken' => $eventInput['replyToken'],
        ]);
    }

    private function setEventDetailVideoPlayComplete($eventId, $eventInput)
    {
        MessagingApiVideoPlayComplete::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'trackingId' => $eventInput['videoPlayComplete']['trackingId'],
        ]);
    }

    private function setEventDetailBeacon($eventId, $eventInput)
    {
        MessagingApiBeacon::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'beaconHwid' => $eventInput['beacon']['hwid'],
            'beaconType' => $eventInput['beacon']['type'],
            'beaconDm' => $eventInput['beacon']['dm'] ?? null,
        ]);
    }

    private function setEventDetailAccountLink($eventId, $eventInput)
    {
        MessagingApiAccountLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'link' => $eventInput['link'],
        ]);
    }

    private function setEventDetailThings($eventId, $eventInput)
    {
        if ($eventInput['things']['type'] === 'link') {
            $this->setEventDetailThingsLink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'unlink') {
            $this->setEventDetailThingsUnlink($eventId, $eventInput);
        } elseif ($eventInput['things']['type'] === 'scenarioResult') {
            $this->setEventDetailThingsScenarioResult($eventId, $eventInput);
        }
    }

    private function setEventDetailThingsLink($eventId, $eventInput)
    {
        MessagingApiThingsLink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function setEventDetailThingsUnlink($eventId, $eventInput)
    {
        MessagingApiThingsUnlink::create([
            'webhookEventId' => $eventId,
            'replyToken' => $eventInput['replyToken'],
            'thingsDeviceId' => $eventInput['things']['deviceId']
        ]);
    }

    private function setEventDetailThingsScenarioResult($eventId, $eventInput)
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
