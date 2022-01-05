<?php

namespace Tests\Unit\Traits;

trait MessagingApiRequestTestData
{
    public function getEventInput() : array
    {
        return array(
            'destination' => 'xxxxxxxxxx',
            'events' => array(
                array(
                    'type' => 'message',
                    'message' => array(
                        'type' => 'text',
                        'id' => '14353798921116',
                        'text' => 'Hello, world'
                    ),
                    'timestamp' => 1625665242211,
                    'source' => array(
                        'type' => 'user',
                        'userId' => 'U80696558e1aa831...'
                    ),
                    'replyToken' => '757913772c4646b784d4b7ce46d12671',
                    'mode' => 'active'
                ),
                array(
                    'type' => 'follow',
                    'timestamp' => 1625665242214,
                    'source' => array(
                        'type' => 'group',
                        'groupId' => 'Ca56f94637c...',
                        'userId' => 'U4af4980629...'
                    ),
                    'replyToken' => '757913772c4646b784d4b7ce46d12671',
                    'mode' => 'active'
                ),
                array(
                    'type' => 'unfollow',
                    'timestamp' => 1625665242215,
                    'source' => array(
                        'type' => 'room',
                        'roomId' => 'Ra8dbf4673c...',
                        'userId' => 'U850014438e...'
                    ),
                    'mode' => 'active'
                )
            )
        );
    }


    public function getEventMessageInput() : array
    {
        return array(
            'type' => 'message',
            'timestamp' => 1625665242211,
            'source' => array(
                'type' => 'user',
                'userId' => 'U80696558e1aa831...'
            ),
            'replyToken' => '757913772c4646b784d4b7ce46d12671',
            'mode' => 'active'
        );
    }

    public function getEventMessageTextInput() : array
    {
        return array(
            'id' => '325708',
            'type' => 'text',
            'text' => '@example Hello, world! (love)',
            'emojis' => array(
                array(
                    'index' => 14,
                    'length' => 6,
                    'productId' => '5ac1bfd5040ab15980c9b435',
                    'emojiId' => '001',
                )
            ),
            'mention' => array(
                'mentionees' => array(
                    array(
                        'index' => 0,
                        'length' => 8,
                        'userId' => 'U850014438e...',
                    )
                )
            )
        );
    }

    public function getEventMessageImageInput() : array
    {
        return array(
            'type' => 'image',
            'id' => '354718705033693859',
            'contentProvider' => array(
                'type' => 'external',
                'originalContentUrl' => 'https://example.com/original.png',
                'previewImageUrl' => 'https://example.com/preview.jpg'
            ),
            'imageSet' => array(
                'id' => 'E005D41A7288F41B65593ED38FF6E9834B046AB36A37921A56BC236F13A91855',
                'index' => 1,
                'total' => 2
            )
        );
    }

    public function getEventMessageVideoInput() : array
    {
        return array(
            'id' => '325708',
            'type' => 'video',
            'duration' => 60000,
            'contentProvider' => array(
                'type' => 'external',
                'originalContentUrl' => 'https://example.com/original.mp4',
                'previewImageUrl' => 'https://example.com/preview.jpg'
            )
        );
    }

    public function getEventMessageAudioInput() : array
    {
        return array(
            'id' => '325708',
            'type' => 'audio',
            'duration' => 60000,
            'contentProvider' => array(
                'type' => 'external',
                'originalContentUrl' => 'https://example.com/original.wav'
            )
        );
    }

    public function getEventMessageFileInput() : array
    {
        return array(
            'id' => '325708',
            'type' => 'file',
            'fileName' => 'file.txt',
            'fileSize' => 2138,
        );
    }

    public function getEventMessageLocationInput() : array
    {
        return array(
            'id' => '325708',
            'type' => 'location',
            'title' => 'my location',
            'address' => '日本、〒160-0004 東京都新宿区四谷１丁目６−１',
            'latitude' => 35.687574,
            'longitude' => 139.72922,
        );
    }

    public function getEventMessageStickerInput() : array
    {
        return array(
            'type' => 'sticker',
            'id' => '1501597916',
            'stickerId' => '52002738',
            'packageId' => '11537',
            'stickerResourceType' => 'ANIMATION',
            'keywords' => array(
                'cony',
                'sally',
                'Staring',
                'hi',
                'whatsup',
                'line',
                'howdy',
                'HEY',
                'Peeking',
                'wave',
                'peek',
                'Hello',
                'yo',
                'greetings'
            ),
        );
    }

    public function getEventUnsendInput() : array
    {
        return array(
            'type' => 'unsend',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'group',
                'groupId' => 'Ca56f94637c...',
                'userId' => 'U4af4980629...'
            ),
            'unsend' => array(
                'messageId' => '325708'
            ),

        );
    }

    public function getEventFollowInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'follow',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U4af4980629...'
            )
        );
    }

    public function getEventUnfollowInput() : array
    {
        return array(
            'type' => 'unfollow',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U4af4980629...'
            )
        );
    }

    public function getEventJoinInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'join',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'group',
                'userId' => 'C4af4980629...'
            )
        );
    }

    public function getEventLeaveInput() : array
    {
        return array(
            'type' => 'leave',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'group',
                'userId' => 'C4af4980629...'
            )
        );
    }

    public function getEventMemberJoinedInput() : array
    {
        return array(
            'replyToken' => '0f3779fba3b349968c5d07db31eabf65',
            'type' => 'memberJoined',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'group',
                'userId' => 'C4af4980629...'
            ),
            'joined' => array(
                'members' => array(
                    array(
                        'type' => 'user',
                        'userId' => 'U4af4980629...'
                    ),
                    array(
                        'type' => 'user',
                        'userId' => 'U91eeaf62d9...'
                    )
                )
            )
        );
    }

    public function getEventMemberLeftInput() : array
    {
        return array(
            'replyToken' => '0f3779fba3b349968c5d07db31eabf65',
            'type' => 'memberLeft',
            'mode' => 'active',
            'timestamp' => 1462629479960,
            'source' => array(
                'type' => 'group',
                'userId' => 'C4af4980629...'
            ),
            'joined' => array(
                'members' => array(
                    array(
                        'type' => 'user',
                        'userId' => 'U4af4980629...'
                    ),
                    array(
                        'type' => 'user',
                        'userId' => 'U91eeaf62d9...'
                    )
                )
            )
        );
    }

    public function getEventPostbackInput() : array
    {
        return array(
            'replyToken' => 'b60d432864f44d079f6d8efe86cf404b',
            'type' => 'postback',
            'mode' => 'active',
            'source' => array(
                'userId' => 'U91eeaf62d...',
                'type' => 'user'
            ),
            'timestamp' => 1619754620404,
            'postback' => array(
                'data' => 'richmenu-changed-to-b',
                'params' => array(
                    array(
                        'newRichMenuAliasId' => 'richmenu-alias-b',
                        'status' => 'SUCCESS'
                    ),
                )
            )
        );
    }

    public function getEventVideoPlayCompleteInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'videoPlayComplete',
            'mode' => 'active',
            'source' => array(
                'type' => 'user',
                'userId' => 'U4af4980629...'
            ),
            'timestamp' => 1462629479859,
            'videoPlayComplete' => array(
                'trackingId' => 'track-id'
            )
        );
    }

    public function getEventBeaconInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'beacon',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U4af4980629...'
            ),
            'beacon' => array(
                'hwid' => 'd41d8cd98f',
                'type' => 'enter',
                'dm' => 'aaa'
            )
        );
    }

    public function getEventAccountLinkInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'accountLink',
            'mode' => 'active',
            'source' => array(
                'userId' => 'U91eeaf62d...',
                'type' => 'user'
            ),
            'timestamp' => 1513669370317,
            'link' => array(
                'result' => 'ok',
                'nonce' => 'xxxxxxxxxxxxxxx',
            )
        );
    }

    public function getEventThingsInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'things',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U91eeaf62d...'
            ),
            'things' => array(
                'deviceId' => 't2c449c9d1...',
                'type' => 'link',
            )
        );
    }

    public function getEventThingsLinkInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'things',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U91eeaf62d...'
            ),
            'things' => array(
                'deviceId' => 't2c449c9d1...',
                'type' => 'link',
            )
        );
    }

    public function getEventThingsUnlinkInput() : array
    {
        return array(
            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
            'type' => 'things',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => array(
                'type' => 'user',
                'userId' => 'U91eeaf62d...'
            ),
            'things' => array(
                'deviceId' => 't2c449c9d1...',
                'type' => 'unlink',
            )
        );
    }

    public function getEventThingsScenarioResultInput() : array
    {
        return array(
            'replyToken' => '0f3779fba3b349968c5d07db31eab56f',
            'type' => 'things',
            'mode' => 'active',
            'source' => array(
                'userId' => 'uXXX',
                'type' => 'user'
            ),
            'timestamp' => 1547817848122,
            'things' => array(
                'type' => 'scenarioResult',
                'deviceId' => 'tXXX',
                'result' => array(
                    'scenarioId' => 'XXX',
                    'revision' => 2,
                    'startTime' => 1547817845950,
                    'endTime' => 1547817845952,
                    'resultCode' => 'success',
                    'bleNotificationPayload' => 'AQ==',
                    'actionResults' => array(
                        array(
                            'type' => 'binary',
                            'data' => '/w=='
                        )
                    ),
                    'errorReason' => 'aaa'
                )
            )
        );
    }
}
