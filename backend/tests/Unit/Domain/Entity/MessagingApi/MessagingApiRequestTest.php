<?php
namespace Tests\Unit\Domain\Entity\MessagingApi;

use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Domain\ValueObject\MessagingApi\Audio;
use App\Domain\ValueObject\MessagingApi\Event;
use App\Domain\ValueObject\MessagingApi\File;
use App\Domain\ValueObject\MessagingApi\Image;
use App\Domain\ValueObject\MessagingApi\Location;
use App\Domain\ValueObject\MessagingApi\Message;
use App\Domain\ValueObject\MessagingApi\Sticker;
use App\Domain\ValueObject\MessagingApi\Text;
use App\Domain\ValueObject\MessagingApi\Video;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;
use Tests\Unit\Traits\MessagingApiRequestTestData;

class MessagingApiRequestTest extends TestCase
{
    use MessagingApiRequestTestData;

    private MessagingApiRequest|\PHPUnit\Framework\MockObject\MockObject $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder('App\Domain\Entity\MessagingApi\MessagingApiRequest')
            ->disableOriginalConstructor()
            ->onlyMethods([
                'createMessage',
                'createText',
                'createImage',
                'createVideo',
                'createAudio',
                'createFile',
                'createLocation',
                'createSticker',
                'getMessageText',
                'getReplyToken',
            ])
            ->getMock();
    }

    public function test__construct()
    {
        $input = $this->getEventInput();
        $request = new MessagingApiRequest($input);
        $reflection = new ReflectionClass($request);

        $property = $reflection->getProperty('events');
        $property->setAccessible(true);
        $events = $property->getValue($request);

        // 検証
        $this->assertCount(3, $events);
        $this->assertInstanceOf(Event::class, $events[0]);
        $this->assertEquals($input['events'][0]['source']['type'], $events[0]->sourceType);
        $this->assertEquals($input['events'][0]['source']['userId'], $events[0]->userId);
        $this->assertNull($events[0]->groupId);
        $this->assertNull($events[0]->roomId);
        $this->assertEquals($input['events'][0]['timestamp'], $events[0]->timestamp);

        $this->assertInstanceOf(Event::class, $events[1]);
        $this->assertEquals($input['events'][1]['source']['type'], $events[1]->sourceType);
        $this->assertEquals($input['events'][1]['source']['userId'], $events[1]->userId);
        $this->assertEquals($input['events'][1]['source']['groupId'], $events[1]->groupId);
        $this->assertNull($events[1]->roomId);
        $this->assertEquals($input['events'][1]['timestamp'], $events[1]->timestamp);

        $this->assertInstanceOf(Event::class, $events[2]);
        $this->assertEquals($input['events'][2]['source']['type'], $events[2]->sourceType);
        $this->assertEquals($input['events'][2]['source']['userId'], $events[2]->userId);
        $this->assertNull($events[2]->groupId);
        $this->assertEquals($input['events'][2]['source']['roomId'], $events[2]->roomId);
        $this->assertEquals($input['events'][2]['timestamp'], $events[2]->timestamp);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createMessage()
    {
        $input = $this->getEventMessageInput();

        /**
         * パターン1 テキストメッセージ
         */
        $input['message'] = $this->getEventMessageTextInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createMessage');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->text);


        /**
         * パターン2 画像メッセージ
         */
        $input['message'] = $this->getEventMessageImageInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->image);

        /**
         * パターン3 動画メッセージ
         */
        $input['message'] = $this->getEventMessageVideoInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->video);


        /**
         * パターン4 音声メッセージ
         */
        $input['message'] = $this->getEventMessageAudioInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->audio);


        /**
         * パターン5 ファイルメッセージ
         */
        $input['message'] = $this->getEventMessageFileInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->file);


        /**
         * パターン6 位置情報メッセージ
         */
        $input['message'] = $this->getEventMessageLocationInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->location);


        /**
         * パターン7 スタンプメッセージ
         */
        $input['message'] = $this->getEventMessageStickerInput();

        // 実行
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Message::class, $valueObject);
        $this->assertEquals($input['replyToken'], $valueObject->replyToken);
        $this->assertNotNull($valueObject->sticker);
    }

    /**
     * @throws ReflectionException
     */
    public function test_createText()
    {
        $input = $this->getEventMessageTextInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createText');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Text::class, $valueObject);
        $this->assertEquals($input['text'], $valueObject->text);
        $this->assertEquals($input['emojis'], $valueObject->emojis);
        $this->assertEquals($input['mention'], $valueObject->mention);
    }

    public function test_createImage()
    {
        $input = $this->getEventMessageImageInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createImage');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Image::class, $valueObject);
        $this->assertEquals($input['imageSet']['id'], $valueObject->imageSetId);
        $this->assertEquals($input['imageSet']['index'], $valueObject->imageSetIndex);
        $this->assertEquals($input['imageSet']['total'], $valueObject->imageSetTotal);
        $this->assertEquals($input['contentProvider']['type'], $valueObject->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $valueObject->originalContentUrl);
        $this->assertEquals($input['contentProvider']['previewImageUrl'], $valueObject->previewImageUrl);

    }

    public function test_createVideo()
    {
        $input = $this->getEventMessageVideoInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createVideo');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Video::class, $valueObject);
        $this->assertEquals($input['duration'], $valueObject->duration);
        $this->assertEquals($input['contentProvider']['type'], $valueObject->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $valueObject->originalContentUrl);
        $this->assertEquals($input['contentProvider']['previewImageUrl'], $valueObject->previewImageUrl);

    }

    public function test_createAudio()
    {
        $input = $this->getEventMessageAudioInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createAudio');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Audio::class, $valueObject);
        $this->assertEquals($input['duration'], $valueObject->duration);
        $this->assertEquals($input['contentProvider']['type'], $valueObject->type);
        $this->assertEquals($input['contentProvider']['originalContentUrl'], $valueObject->originalContentUrl);

    }

    public function test_createFile()
    {
        $input = $this->getEventMessageFileInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createFile');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(File::class, $valueObject);
        $this->assertEquals($input['fileName'], $valueObject->fileName);
        $this->assertEquals($input['fileSize'], $valueObject->fileSize);
    }

    public function test_createLocation()
    {
        $input = $this->getEventMessageLocationInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createLocation');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Location::class, $valueObject);
        $this->assertEquals($input['title'], $valueObject->title);
        $this->assertEquals($input['address'], $valueObject->address);
        $this->assertEquals($input['latitude'], $valueObject->latitude);
        $this->assertEquals($input['longitude'], $valueObject->longitude);

    }

    public function test_createSticker()
    {
        $input = $this->getEventMessageStickerInput();

        // 実行
        $reflection = new ReflectionClass($this->request);
        $method = $reflection->getMethod('createSticker');
        $method->setAccessible(true);
        $valueObject = $method->invoke($this->request, $input);

        // 検証
        $this->assertInstanceOf(Sticker::class, $valueObject);
        $this->assertEquals($input['stickerId'], $valueObject->stickerId);
        $this->assertEquals($input['packageId'], $valueObject->packageId);
        $this->assertEquals($input['stickerResourceType'], $valueObject->stickerResourceType);
        $this->assertEquals($input['stickerResourceType'], $valueObject->stickerResourceType);
        $this->assertEquals($input['keywords'], $valueObject->keywords);

    }

    public function getMessageText()
    {
        $input = $this->getEventInput();
        $request = new MessagingApiRequest($input);
        $this->assertEquals($input['events'][0]['message']['text'], $request->getMessageText());
    }

    public function getReplyToken()
    {
        $input = $this->getEventInput();
        $request = new MessagingApiRequest($input);
        $this->assertEquals($input['events'][0]['replyToken'], $request->getReplyToken());
    }
}
