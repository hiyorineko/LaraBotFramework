<?php
namespace Tests\Unit\Domain\Entity\MessagingApi;

use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Domain\ValueObject\MessagingApi\Audio;
use App\Domain\ValueObject\MessagingApi\File;
use App\Domain\ValueObject\MessagingApi\Image;
use App\Domain\ValueObject\MessagingApi\Location;
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

    private function test_createMessage()
    {

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
