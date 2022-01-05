<?php
namespace App\UseCases;

use App\Domain\Entity\BotApiRequest;
use App\Infrastructures\BotApi\BotApi;

interface UseCase {

    /**
     * UseCaseにBotApiとBotApiRequestを設定する
     * @param BotApi $api
     * @param BotApiRequest $request
     */
    public function __construct(BotApi $api, BotApiRequest $request);

    /**
     * BotApiRequestがUseCaseに合致するかどうかを検証
     * @return bool
     */
    function verify() : bool;

    /**
     * UseCaseを実行
     * @return void
     */
    function exec() : void;
}
