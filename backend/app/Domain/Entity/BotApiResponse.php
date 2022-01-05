<?php
namespace App\Domain\Entity;

use App\UseCases\UseCase;

interface BotApiResponse {

    /**
     * リクエストデータの内容に応じてUseCaseを実行
     * @param BotApiRequest $request
     * @return void
     */
    function useCaseRouter(BotApiRequest $request) : void;

    /**
     * リクエストデータがユースケースに合致するかどうかを検証
     * @param UseCase $useCase
     * @param BotApiRequest $request
     * @return mixed
     */
    function isVerifiedRequest(UseCase $useCase, BotApiRequest $request): mixed;
    /**
     * ユースケースの処理を実行
     * @param UseCase $useCase
     */
    function useCaseExec(UseCase $useCase);
}
