<?php
namespace App\UseCases;

use App\Domain\Entity\BotApiRequest;
use App\Infrastructures\BotApi\BotApi;
use ReflectionClass;
use ReflectionException;

class UseCaseKernel
{
    /**
     * BotApiに応じたUseCaseオブジェクトの配列を返す
     *
     * UseCaseオブジェクトは以下のディレクトリのClassファイルより生成
     * app/UseCases/{** BotApi名 **}/
     *
     * @param BotApi $botApi
     * @param BotApiRequest $request
     * @return UseCase[]
     * @throws ReflectionException
     */
    public function getUseCases(BotApi $botApi, BotApiRequest $request): array
    {
        $func = function(string $value): string {
            return basename(str_replace('.php', '', $value));
        };
        $fileNames = array_map($func, glob(app_path() . '/UseCases/' . $botApi->getUseCaseDirName() . '/' . '{*UseCase.php}', GLOB_BRACE));
        $actions = [];
        foreach ($fileNames as $fileName) {
            $action = new ReflectionClass('App\UseCases\\' . $botApi->getUseCaseDirName() . '\\' .$fileName);
            $actions[] = $action->newInstance($botApi, $request);
        }
        return $actions;
    }
}
