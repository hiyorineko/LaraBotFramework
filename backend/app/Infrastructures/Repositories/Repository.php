<?php
namespace App\Infrastructures\Repositories;

use App\Domain\Entity\BotApiRequest;

interface Repository {

    /**
     * Requestを元にBotApiRequestのEntityを返す
     * @param array $requestBody
     * @return BotApiRequest
     */
    function getRequestEntity(array $requestBody) : BotApiRequest;

    /**
     * Requestをデータストアに登録する
     * @param array $requestBody
     * @return void
     */
    function storeRequest(array $requestBody) : void;
}
