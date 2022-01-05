<?php

namespace App\Infrastructures\BotApi;

interface BotApi
{
    /**
     * BotApiに対応するUseCaseのディレクトリ名を取得
     * @return string
     */
    public function getUseCaseDirName(): string;
}
