<?php

namespace Tests\Unit\Infrastructures;

use App\Infrastructures\MessagingApi;
use Tests\TestCase;

class MessagingApiTest extends TestCase
{
    public function test_createQuickReply()
    {
        $expected = array(
            'items' => 'aaa'
        );
        $result = MessagingApi::createQuickReply($expected['items']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['items'], $result['items']);
    }

    public function test_createQuickReplyItem()
    {
        $expected = array(
            'type' => 'action',
            'imageUrl' => 'aaa',
            'action' => 'bbb'
        );
        $result = MessagingApi::createQuickReplyItem($expected['imageUrl'], $expected['action']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['imageUrl'], $result['imageUrl']);
        $this->assertEquals($expected['action'], $result['action']);
    }

    public function test_createSender()
    {
        $expected = array(
            'name' => 'sender',
            'iconUrl' => 'iconurl',
        );
        $result = MessagingApi::createSender();
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['name'], $result['name']);
        $this->assertEquals($expected['iconUrl'], $result['iconUrl']);
    }

    public function test_createTextMessage()
    {
        $expected = array(
            'type' => 'text',
            'text' => 'aaa',
            'emojis' => 'bbb',
        );
        $result = MessagingApi::createTextMessage($expected['text'], $expected['emojis']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['text'], $result['text']);
        $this->assertEquals($expected['emojis'], $result['emojis']);
    }

    public function test_createStickerMessage()
    {
        $expected = array(
            'type' => 'sticker',
            'packageId' => 'aaa',
            'stickerId' => 'bbb'
        );
        $result = MessagingApi::createStickerMessage($expected['packageId'], $expected['stickerId']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['packageId'], $result['packageId']);
        $this->assertEquals($expected['stickerId'], $result['stickerId']);
    }

    public function test_createImageMessage()
    {
        $expected = array(
            'type' => 'image',
            'originalContentUrl' => 'aaa',
            'previewImageUrl' => 'bbb'
        );
        $result = MessagingApi::createImageMessage($expected['originalContentUrl'], $expected['previewImageUrl']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['originalContentUrl'], $result['originalContentUrl']);
        $this->assertEquals($expected['previewImageUrl'], $result['previewImageUrl']);
    }

    public function test_createVideoMessage()
    {
        $expected = array(
            'type' => 'video',
            'originalContentUrl' => 'aaa',
            'previewImageUrl' => 'bbb',
            'trackingId' => 'ccc'
        );
        $result = MessagingApi::createVideoMessage($expected['originalContentUrl'], $expected['previewImageUrl'], $expected['trackingId']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['originalContentUrl'], $result['originalContentUrl']);
        $this->assertEquals($expected['previewImageUrl'], $result['previewImageUrl']);
        $this->assertEquals($expected['trackingId'], $result['trackingId']);
    }

    public function test_createAudioMessage()
    {
        $expected = array(
            'type' => 'audio',
            'originalContentUrl' => 'aaa',
        );
        $result = MessagingApi::createAudioMessage($expected['originalContentUrl']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['originalContentUrl'], $result['originalContentUrl']);
    }

    public function test_createLocationMessage()
    {
        $expected = array(
            'type' => 'location',
            'title' => 'aaa',
            'address' => 'bbb',
            'latitude' => 'ccc',
            'longitude' => 'ddd',
        );
        $result = MessagingApi::createLocationMessage($expected['title'], $expected['address'], $expected['latitude'], $expected['longitude']);
        $this->assertSame(array_keys($expected), array_keys($result));
        $this->assertEquals($expected['type'], $result['type']);
        $this->assertEquals($expected['title'], $result['title']);
        $this->assertEquals($expected['address'], $result['address']);
        $this->assertEquals($expected['latitude'], $result['latitude']);
        $this->assertEquals($expected['longitude'], $result['longitude']);
    }
}
