<?php

namespace App\Infrastructures;

use Illuminate\Support\Facades\Config;

class MessagingApi
{

    /**
     * QuickReplyオブジェクトを作成
     * @param $quickReplyItems
     * @return array
     */
    public static function createQuickReply($quickReplyItems): array
    {
        return array(
            'items' => $quickReplyItems
        );
    }

    /**
     * QuickReplyItemオブジェクトを作成
     */
    public static function createQuickReplyItem($imageUrl, $action): array
    {
        return array(
            'type' => 'action',
            'imageUrl' => $imageUrl,
            'action' => $action
        );
    }

    /**
     * Senderオブジェクトを作成
     * @return array
     */
    public static function createSender(): array
    {
        return array(
            'name' => Config::get('messagingApi.sender_name'),
            'iconUrl' => Config::get('messagingApi.sender_icon_url'),
        );
    }

    /**
     * Messageオブジェクト（text）を作成
     * @param $text
     * @param $emojis
     * @return array
     */
    public static function createTextMessage($text, $emojis): array
    {
        return array(
            'type' => 'text',
            'text' => $text,
            'emojis' => $emojis
        );
    }

    /**
     * Messageオブジェクト（sticker）を作成
     * @param $packageId
     * @param $stickerId
     * @return array
     */
    public static function createStickerMessage($packageId, $stickerId): array
    {
        return array(
            'type' => 'sticker',
            'packageId' => $packageId,
            'stickerId' => $stickerId
        );
    }

    /**
     * Messageオブジェクト（image）を作成
     * @param $originalContentUrl
     * @param $previewImageUrl
     * @return array
     */
    public static function createImageMessage($originalContentUrl, $previewImageUrl): array
    {
        return array(
            'type' => 'image',
            'originalContentUrl' => $originalContentUrl,
            'previewImageUrl' => $previewImageUrl
        );
    }

    /**
     * Messageオブジェクト（video）を作成
     * @param $originalContentUrl
     * @param $previewImageUrl
     * @param $trackingId
     * @return array
     */
    public static function createVideoMessage($originalContentUrl, $previewImageUrl, $trackingId): array
    {
        return array(
            'type' => 'video',
            'originalContentUrl' => $originalContentUrl,
            'previewImageUrl' => $previewImageUrl,
            'trackingId' => $trackingId
        );
    }

    /**
     * Messageオブジェクト（audio）を作成
     * @param $originalContentUrl
     * @return array
     */
    public static function createAudioMessage($originalContentUrl): array
    {
        return array(
            'type' => 'audio',
            'originalContentUrl' => $originalContentUrl
        );
    }

    /**
     * Messageオブジェクト（location）を作成
     * @param $title
     * @param $address
     * @param $latitude
     * @param $longitude
     * @return array
     */
    public static function createLocationMessage($title, $address, $latitude, $longitude): array
    {
        return array(
            'type' => 'location',
            'title' => $title,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
        );
    }

    public static function createImageMapMessage()
    {
        // TODO
    }

    public static function createTemplateMessage()
    {
        // TODO
    }

    public static function createFlexMessage()
    {
        // TODO
    }

    public static function createBubbleMessage()
    {
        // TODO
    }

    public static function createCarouselMessage()
    {
        // TODO
    }

    public static function createButtonMessage()
    {
        // TODO
    }

    public static function reply($replyToken, $messages)
    {
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . config('messagingApi.channel_access_token'),
        );

        $context = stream_context_create(array(
            "http" => array(
                "method" => "POST",
                "header" => implode("\r\n", $header),
                "content" => json_encode([
                    "replyToken" => $replyToken,
                    "messages" => $messages,
                ]),
            ),
        ));

        $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            http_response_code(500);
            error_log("Request failed: " . $response);
        }
    }

    public static function push()
    {
    }

    public static function multicast()
    {

    }

    public static function narrowcast()
    {

    }

    public static function progressNarrowcast()
    {

    }

    public static function broadcast()
    {

    }

    public static function downloadContent()
    {
    }

    public static function quota()
    {
    }

    public static function quotaConsumption()
    {

    }

    public static function deliveryReply()
    {

    }

    public static function deliveryPush()
    {

    }

    public static function deliveryMulticast()
    {

    }

    public static function deliveryBroadcast()
    {

    }
}
