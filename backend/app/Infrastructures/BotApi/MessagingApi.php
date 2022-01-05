<?php

namespace App\Infrastructures\BotApi;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MessagingApi implements BotApi
{
    public function getUseCaseDirName(): string
    {
        return "MessagingApi";
    }

    /**
     * QuickReplyオブジェクトを作成
     * @param $quickReplyItems
     * @return array
     */
    public function createQuickReply($quickReplyItems): array
    {
        return array(
            'items' => $quickReplyItems
        );
    }

    /**
     * QuickReplyItemオブジェクトを作成
     */
    public function createQuickReplyItem($imageUrl, $action): array
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
    public function createSender(): array
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
    public function createTextMessage($text, array $emojis = []): array
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
    public function createStickerMessage($packageId, $stickerId): array
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
    public function createImageMessage($originalContentUrl, $previewImageUrl): array
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
    public function createVideoMessage($originalContentUrl, $previewImageUrl, $trackingId): array
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
    public function createAudioMessage($originalContentUrl): array
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
    public function createLocationMessage($title, $address, $latitude, $longitude): array
    {
        return array(
            'type' => 'location',
            'title' => $title,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
        );
    }

    public function createImageMapMessage()
    {
        // TODO
    }

    public function createTemplateMessage()
    {
        // TODO
    }

    public function createFlexMessage()
    {
        // TODO
    }

    public function createBubbleMessage()
    {
        // TODO
    }

    public function createCarouselMessage()
    {
        // TODO
    }

    public function createButtonMessage()
    {
        // TODO
    }

    private function execApi($curlOptions) {
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        if (curl_getinfo($curl, CURLINFO_RESPONSE_CODE) != '200') {
            Log::error($response);
        }
        curl_close($curl);
    }

    public function reply($replyToken, $messages, $notificationDisabled = false)
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
        $this->execApi($options);
    }

    public function push($to, $messages, $notificationDisabled = false, $retryKey = null)
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
        $this->execApi($options);
    }

    public function multicast()
    {
        // TODO
    }

    public function narrowcast()
    {
        // TODO
    }

    public function progressNarrowcast()
    {
        // TODO
    }

    public function broadcast()
    {
        // TODO
    }

    public function downloadContent()
    {
        // TODO
    }

    public function quota()
    {
        // TODO
    }

    public function quotaConsumption()
    {
        // TODO
    }

    public function deliveryReply()
    {
        // TODO
    }

    public function deliveryPush()
    {
        // TODO
    }

    public function deliveryMulticast()
    {
        // TODO
    }

    public function deliveryBroadcast()
    {
        // TODO
    }

}
