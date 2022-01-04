<?php
namespace App\Domain\Entity\MessagingApi;

use App\Domain\Entity\BotApiRequest;
use App\Domain\Entity\BotApiResponse;
use App\Infrastructures\BotApi\MessagingApi;
use App\UseCases\UseCaseKernel;
use ReflectionException;

class MessagingApiResponse implements BotApiResponse
{
    private UseCaseKernel $kernel;

    function __construct(UseCaseKernel $kernel) {
        $this->kernel = $kernel;
    }

    /**
     * @throws ReflectionException
     */
    public function actionRouter(BotApiRequest $request)
    {
        foreach ($this->kernel->getActions(new MessagingApi()) as $action) {
            if ($this->isVerifiedEvent($action, $request) === true) {
                $this->actionExec($action);
            }
        }
    }

    /**
     * @param object $action
     * @param BotApiRequest $request
     * @return mixed
     */
    private function isVerifiedEvent(object $action, BotApiRequest $request): mixed
    {
        return $action->verify($request);
    }

    /**
     * @param object $action
     */
    private function actionExec(object $action)
    {
        $action->exec($action);
    }
}
