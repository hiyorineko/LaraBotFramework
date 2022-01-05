<?php
namespace App\Domain\Entity;

use App\UseCases\UseCase;

interface BotApiResponse {

    /**
     * BotApiRequestの内容に応じてUseCaseを実行
     * @param BotApiRequest $request
     * @return void
     */
    function useCaseRouter(BotApiRequest $request) : void;

    /**
     * BotApiRequestがUseCaseに合致するかどうかを検証
     * @param UseCase $useCase
     * @return mixed
     */
    function useCaseVerify(UseCase $useCase): mixed;

    /**
     * UseCaseの処理を実行
     * @param UseCase $useCase
     */
    function useCaseExec(UseCase $useCase);
}
