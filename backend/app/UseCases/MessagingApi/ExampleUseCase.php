<?php
namespace App\UseCases\MessagingApi;

use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Domain\Entity\BotApiRequest;
use App\Infrastructures\BotApi\BotApi;
use App\UseCases\UseCase;

class ExampleUseCase implements UseCase {

    private BotApi $api;
    private MessagingApiRequest $request;

    public function __construct(BotApi $api, BotApiRequest $request) {
        $this->api = $api;
        $this->request = $request;
    }

    public function verify() : bool
    {
        return true;
    }

    public function exec() : void
    {
        $text = $this->request->getMessageText();
        $replyToken = $this->request->getReplyToken();
        $messages = array($this->api->createTextMessage($text));
        $this->api->reply($replyToken, $messages);
    }
}
