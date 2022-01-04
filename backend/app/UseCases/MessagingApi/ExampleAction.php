<?php
namespace App\UseCases\MessagingApi;

use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Domain\Entity\BotApiRequest;
use App\Infrastructures\BotApi\MessagingApi;
use App\UseCases\Action;
use App\Infrastructures\BotApi\BotApi;

class ExampleAction implements Action {

    private BotApi $api;
    private MessagingApiRequest $request;

    public function __construct(MessagingApi $api) {
        $this->api = $api;
    }

    public function verify(BotApiRequest $request): bool
    {
        $this->request = $request;
        return true;
    }

    public function exec()
    {
        $text = $this->request->getMessageText();
        $replyToken = $this->request->getReplyToken();
        $messages = array($this->api->createTextMessage($text));
        $this->api->reply($replyToken, $messages);
    }
}
