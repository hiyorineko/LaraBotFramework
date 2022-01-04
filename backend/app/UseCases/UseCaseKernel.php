<?php
namespace App\UseCases;

use App\Infrastructures\BotApi\BotApi;
use ReflectionClass;
use ReflectionException;

class UseCaseKernel
{
    /**
     * @param BotApi $botApi
     * @return ReflectionClass[]
     * @throws ReflectionException
     */
    public function getActions(BotApi $botApi): array
    {
        $func = function(string $value): string {
            return basename(str_replace('.php', '', $value));
        };
        $fileNames = array_map($func, glob(app_path() . '/UseCases/' . $botApi->getDirName() . '/' . '{*Action.php}', GLOB_BRACE));
        $actions = [];
        foreach ($fileNames as $fileName) {
            $action = new ReflectionClass('App\UseCases\\' . $botApi->getDirName() . '\\' .$fileName);
            $actions[] = $action->newInstance($botApi);
        }
        return $actions;
    }
}
