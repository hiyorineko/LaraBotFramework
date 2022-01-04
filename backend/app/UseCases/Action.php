<?php
namespace App\UseCases;

use App\Domain\Entity\BotApiRequest;

interface Action {
    public function verify(BotApiRequest $request);
    public function exec();
}
