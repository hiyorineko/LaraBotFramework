<?php

namespace App\Infrastructures;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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
     * @param array $emojis
     * @return array
     */
    public static function createTextMessage($text, array $emojis = []): array
    {
        $message = array(
            'type' => 'text',
            'text' => $text,
        );
        if (!empty($emojis)) {
            $message['emojis'] = $emojis;
        }
        return $message;
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

    private static function execApi($curlOptions) {
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        if (curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != '200') {
            Log::error($response);
        }
        curl_close($curl);
    }

    public static function reply($replyToken, $messages, $notificationDisabled = false)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . config('messagingApi.channel_access_token'),
        );
        $body = array(
            'replyToken' => $replyToken,
            'messages' => $messages,
            'notificationDisabled' => $notificationDisabled
        );
        $options = array(CURLOPT_URL => 'https://api.line.me/v2/bot/message/reply',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($body));
        self::execApi($options);
    }

    public static function push($to, $messages, $notificationDisabled = false, $retryKey = null)
    {
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . config('messagingApi.channel_access_token'),
        );
        if (!$retryKey) {
            $header['X-Line-Retry-Key'] = $retryKey;
        }
        $body = array(
            'to' => $to,
            'messages' => $messages,
            'notificationDisabled' => $notificationDisabled
        );
        $options = array(CURLOPT_URL => 'https://api.line.me/v2/bot/message/push',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($body));
        self::execApi($options);
    }

    public static function multicast()
    {
        // TODO
    }

    public static function narrowcast()
    {
        // TODO
    }

    public static function progressNarrowcast()
    {
        // TODO
    }

    public static function broadcast()
    {
        // TODO
    }

    public static function downloadContent()
    {
        // TODO
    }

    public static function quota()
    {
        // TODO
    }

    public static function quotaConsumption()
    {
        // TODO
    }

    public static function deliveryReply()
    {
        // TODO
    }

    public static function deliveryPush()
    {
        // TODO
    }

    public static function deliveryMulticast()
    {
        // TODO
    }

    public static function deliveryBroadcast()
    {
        // TODO
    }
}
