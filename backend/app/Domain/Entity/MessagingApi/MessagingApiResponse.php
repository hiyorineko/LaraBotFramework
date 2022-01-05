<?php
namespace App\Domain\Entity\MessagingApi;

use App\Domain\Entity\BotApiRequest;
use App\Domain\Entity\BotApiResponse;
use App\Infrastructures\BotApi\MessagingApi;
use App\UseCases\UseCase;
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
    public function useCaseRouter(BotApiRequest $request) : void
    {
        foreach ($this->kernel->getUseCases(new MessagingApi(), $request) as $useCase) {
            if ($this->useCaseVerify($useCase) === true) {
                $this->useCaseExec($useCase);
            }
        }
    }

    public function useCaseVerify(UseCase $useCase): bool
    {
        return $useCase->verify();
    }

    public function useCaseExec(UseCase $useCase)
    {
        $useCase->exec();
    }
}
