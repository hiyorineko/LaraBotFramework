<?php
namespace App\Domain\Entity;

interface BotApiRequest {

    /**
     * Requestをマッピング
     * @param array $requestBody
     */
    function __construct(array $requestBody);
    /**
     * メッセージテキストを取得
     * @return string
     */
    function getMessageText() : string;
}
