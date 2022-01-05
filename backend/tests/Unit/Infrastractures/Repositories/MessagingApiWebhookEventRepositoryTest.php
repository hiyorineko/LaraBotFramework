<?php

namespace Tests\Unit\Infrastractures\Repositories;

use App\Infrastructures\EloquentModels\MessagingApiAccountLink;
use App\Infrastructures\EloquentModels\MessagingApiBeacon;
use App\Infrastructures\EloquentModels\MessagingApiFollow;
use App\Infrastructures\EloquentModels\MessagingApiJoin;
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
use App\Infrastructures\EloquentModels\MessagingApiUnsend;
use App\Infrastructures\EloquentModels\MessagingApiVideoPlayComplete;
use App\Infrastructures\EloquentModels\MessagingApiWebhookEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructures\Repositories\MessagingApiWebhookEventRepository;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;
use Tests\Unit\Traits\MessagingApiRequestTestData;

class MessagingApiWebhookEventRepositoryTest extends TestCase
{
    use RefreshDatabase, MessagingApiRequestTestData;

    private MessagingApiWebhookEventRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new MessagingApiWebhookEventRepository();
    }

    public function test_createEvents()
    {
        $input = $this->getEventInput();

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEvents');
        $method->setAccessible(true);
        $events = $method->invoke($this->repository, $input);

        // 検証
        $this->assertEquals($input['destination'], $events[0]->destination);
        $this->assertEquals($input['events'][0]['mode'], $events[0]->mode);
        $this->assertEquals($input['events'][0]['source']['type'], $events[0]->sourceType);
        $this->assertEquals($input['events'][0]['source']['userId'], $events[0]->userId);
        $this->assertNull($events[0]->groupId);
        $this->assertNull($events[0]->roomId);
        $this->assertEquals($input['events'][0]['timestamp'], $events[0]->timestamp);

        $this->assertEquals($input['destination'], $events[1]->destination);
        $this->assertEquals($input['events'][1]['mode'], $events[1]->mode);
        $this->assertEquals($input['events'][1]['source']['type'], $events[1]->sourceType);
        $this->assertEquals($input['events'][1]['source']['userId'], $events[1]->userId);
        $this->assertEquals($input['events'][1]['source']['groupId'], $events[1]->groupId);
        $this->assertNull($events[1]->roomId);
        $this->assertEquals($input['events'][1]['timestamp'], $events[1]->timestamp);

        $this->assertEquals($input['destination'], $events[2]->destination);
        $this->assertEquals($input['events'][2]['mode'], $events[2]->mode);
        $this->assertEquals($input['events'][2]['source']['type'], $events[2]->sourceType);
        $this->assertEquals($input['events'][2]['source']['userId'], $events[2]->userId);
        $this->assertNull($events[2]->groupId);
        $this->assertEquals($input['events'][2]['source']['roomId'], $events[2]->roomId);
        $this->assertEquals($input['events'][2]['timestamp'], $events[2]->timestamp);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventDetail()
    {
        /**
         * パターン1 メッセージイベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventMessageInput();
        $input['message'] = $this->getEventMessageTextInput();

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventDetail');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_massages', ['webhookEventId' => $event->id]);

        /**
         * パターン2 送信取消イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventUnsendInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_unsends', ['webhookEventId' => $event->id]);

        /**
         * パターン3 フォローイベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventFollowInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_follows', ['webhookEventId' => $event->id]);

        /**
         * パターン4 フォロー解除イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventUnfollowInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_unfollows', ['webhookEventId' => $event->id]);

        /**
         * パターン5 参加イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventJoinInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_joins', ['webhookEventId' => $event->id]);

        /**
         * パターン6 退出イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventLeaveInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_leaves', ['webhookEventId' => $event->id]);

        /**
         * パターン7 メンバー参加イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventMemberJoinedInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_member_joineds', ['webhookEventId' => $event->id]);

        /**
         * パターン8 メンバー退出イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventMemberLeftInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_member_lefts', ['webhookEventId' => $event->id]);

        /**
         * パターン9 ポストバックイベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventPostbackInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_postbacks', ['webhookEventId' => $event->id]);

        /**
         * パターン10 動画視聴完了イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventVideoPlayCompleteInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_video_play_completes', ['webhookEventId' => $event->id]);

        /**
         * パターン11 ビーコンイベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventBeaconInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_beacons', ['webhookEventId' => $event->id]);

        /**
         * パターン12 アカウント連携イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventAccountLinkInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_account_links', ['webhookEventId' => $event->id]);

        /**
         * パターン13 デバイス連携イベント
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input = $this->getEventThingsInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_things_links', ['webhookEventId' => $event->id]);

    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventMessage()
    {
        $input = $this->getEventMessageInput();

        /**
         * パターン1 テキストメッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageTextInput();

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessage');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_texts', ['messageId' => $record->id]);

        /**
         * パターン2 画像メッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageImageInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_images', ['messageId' => $record->id]);


        /**
         * パターン3 動画メッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageVideoInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_videos', ['messageId' => $record->id]);


        /**
         * パターン4 音声メッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageAudioInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_audios', ['messageId' => $record->id]);


        /**
         * パターン5 ファイルメッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageFileInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_files', ['messageId' => $record->id]);


        /**
         * パターン6 位置情報メッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageLocationInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_locations', ['messageId' => $record->id]);


        /**
         * パターン7 スタンプメッセージ
         */
        $event = MessagingApiWebhookEvent::create([]);
        $input['message'] = $this->getEventMessageStickerInput();

        // 実行
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMassage::where(['webhookEventId' => $event->id])->first();
        $this->assertNotNull($record);
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertDatabaseHas('messaging_api_massage_stickers', ['messageId' => $record->id]);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageText()
    {
        // テストデータ
        $input = $this->getEventMessageTextInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageText');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageText::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['text'], $record->text);
        $this->assertEquals($input['emojis'], $record->emojis);
        $this->assertEquals($input['mention'], $record->mention);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageImage()
    {
        // テストデータ
        $input = $this->getEventMessageImageInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageImage');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageImage::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['imageSet']['id'], $record->imageSetId);
        $this->assertEquals($input['imageSet']['index'], $record->imageSetIndex);
        $this->assertEquals($input['imageSet']['total'], $record->imageSetTotal);
        $this->assertEquals($input['contentProvider']['type'], $record->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $record->originalContentUrl);
        $this->assertEquals($input['contentProvider']['previewImageUrl'], $record->previewImageUrl);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageVideo()
    {
        // テストデータ
        $input = $this->getEventMessageVideoInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageVideo');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageVideo::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['duration'], $record->duration);
        $this->assertEquals($input['contentProvider']['type'], $record->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $record->originalContentUrl);
        $this->assertEquals($input['contentProvider']['previewImageUrl'], $record->previewImageUrl);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageAudio()
    {
        // テストデータ
        $input = $this->getEventMessageAudioInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageAudio');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageAudio::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['duration'], $record->duration);
        $this->assertEquals($input['contentProvider']['type'], $record->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $record->originalContentUrl);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageFile()
    {
        // テストデータ
        $input = $this->getEventMessageFileInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageFile');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageFile::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['fileName'], $record->fileName);
        $this->assertEquals($input['fileSize'], $record->fileSize);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageLocation()
    {
        // テストデータ
        $input = $this->getEventMessageLocationInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageLocation');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageLocation::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['title'], $record->title);
        $this->assertEquals($input['address'], $record->address);
        $this->assertEquals($input['latitude'], $record->latitude);
        $this->assertEquals($input['longitude'], $record->longitude);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMessageSticker()
    {
        // テストデータ
        $input = $this->getEventMessageStickerInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMessageSticker');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiMassageSticker::where(['messageId' => $message->id])->first();
        $this->assertEquals($input['stickerId'], $record->stickerId);
        $this->assertEquals($input['packageId'], $record->packageId);
        $this->assertEquals($input['stickerResourceType'], $record->stickerResourceType);
        $this->assertEquals($input['stickerResourceType'], $record->stickerResourceType);
        $this->assertEquals($input['keywords'], $record->keywords);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventUnsend()
    {
        // テストデータ
        $input = $this->getEventUnsendInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventUnsend');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiUnsend::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['unsend']['messageId'], $record->messageId);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventFollow()
    {
        // テストデータ
        $input = $this->getEventFollowInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventFollow');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiFollow::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventUnfollow()
    {
        // テストデータ
        $input = $this->getEventUnfollowInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventUnfollow');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_unfollows', ['webhookEventId' => $event->id]);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventJoin()
    {
        // テストデータ
        $input = $this->getEventJoinInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventJoin');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiJoin::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventLeave()
    {
        // テストデータ
        $input = $this->getEventLeaveInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventLeave');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $this->assertDatabaseHas('messaging_api_leaves', ['webhookEventId' => $event->id]);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMemberJoined()
    {
        // テストデータ
        $input = $this->getEventMemberJoinedInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMemberJoined');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMemberJoined::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['joined']['members'], $record->members);
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventMemberLeft()
    {
        // テストデータ
        $input = $this->getEventMemberLeftInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventMemberLeft');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiMemberLeft::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['joined']['members'], $record->members);
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventPostback()
    {
        // テストデータ
        $input = $this->getEventPostbackInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventPostback');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiPostback::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['postback']['data'], $record->data);
        $this->assertEquals($input['postback']['params'], $record->params);
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }


    /**
     * @throws ReflectionException
     */
    public function test_createEventVideoPlayComplete()
    {
        // テストデータ
        $input = $this->getEventVideoPlayCompleteInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventVideoPlayComplete');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiVideoPlayComplete::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['videoPlayComplete']['trackingId'], $record->trackingId);
        $this->assertEquals($input['replyToken'], $record->replyToken);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventBeacon()
    {
        // テストデータ
        $input = $this->getEventBeaconInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventBeacon');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiBeacon::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertEquals($input['beacon']['hwid'], $record->beaconHwid);
        $this->assertEquals($input['beacon']['type'], $record->beaconType);
        $this->assertEquals($input['beacon']['dm'], $record->beaconDm);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventAccountLink()
    {
        // テストデータ
        $input = $this->getEventAccountLinkInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventAccountLink');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiAccountLink::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertEquals($input['link'], $record->link);
    }



    /**
     * @throws ReflectionException
     */
    public function test_createEventThings()
    {
        /**
         * パターン1 #デバイス連携イベント
         */
        // テストデータ
        $input = $this->getEventThingsLinkInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventThings');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);
        // 検証
        $this->assertDatabaseHas('messaging_api_things_links', ['webhookEventId' => $event->id]);


        /**
         * パターン2 デバイス連携解除イベント
         */
        // テストデータ
        $input = $this->getEventThingsUnlinkInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $method->invoke($this->repository, $event->id, $input);
        // 検証
        $this->assertDatabaseHas('messaging_api_things_unlinks', ['webhookEventId' => $event->id]);

        /**
         * パターン3 LINE Thingsシナリオ実行イベント
         */
        // テストデータ
        $input = $this->getEventThingsScenarioResultInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $method->invoke($this->repository, $event->id, $input);
        // 検証
        $this->assertDatabaseHas('messaging_api_things_scenario_results', ['webhookEventId' => $event->id]);

    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventThingsLink()
    {
        // テストデータ
        $input = $this->getEventThingsLinkInput();
        $event = MessagingApiWebhookEvent::create([]);
        $message = MessagingApiMassage::create([
            'webhookEventId' => $event->id
        ]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventThingsLink');
        $method->setAccessible(true);
        $method->invoke($this->repository, $message->id, $input);

        // 検証
        $record = MessagingApiThingsLink::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertEquals($input['things']['deviceId'], $record->thingsDeviceId);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventThingsUnlink()
    {
        // テストデータ
        $input = $this->getEventThingsUnlinkInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventThingsUnlink');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiThingsUnlink::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertEquals($input['things']['deviceId'], $record->thingsDeviceId);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createEventThingsScenarioResult()
    {
        // テストデータ
        $input = $this->getEventThingsScenarioResultInput();
        $event = MessagingApiWebhookEvent::create([]);

        // 実行
        $reflection = new ReflectionClass($this->repository);
        $method = $reflection->getMethod('createEventThingsScenarioResult');
        $method->setAccessible(true);
        $method->invoke($this->repository, $event->id, $input);

        // 検証
        $record = MessagingApiThingsScenarioResult::where(['webhookEventId' => $event->id])->first();
        $this->assertEquals($input['replyToken'], $record->replyToken);
        $this->assertEquals($input['things']['deviceId'], $record->thingsDeviceId);
        $this->assertEquals($input['things']['result']['scenarioId'], $record->thingsResultScenarioId);
        $this->assertEquals($input['things']['result']['revision'], $record->thingsResultRevision);
        $this->assertEquals($input['things']['result']['startTime'], $record->thingsResultStartTime);
        $this->assertEquals($input['things']['result']['endTime'], $record->thingsResultEndTime);
        $this->assertEquals($input['things']['result']['resultCode'], $record->thingsResultResultCode);
        $this->assertEquals($input['things']['result']['actionResults'], $record->thingsResultActionResults);
        $this->assertEquals($input['things']['result']['bleNotificationPayload'], $record->thingsResultBleNotificationPayload);
        $this->assertEquals($input['things']['result']['errorReason'], $record->thingsResultErrorReason);
    }
}
