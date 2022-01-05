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
        foreach ($this->kernel->getUseCases(new MessagingApi()) as $useCase) {
            if ($this->isVerifiedRequest($useCase, $request) === true) {
                $this->useCaseExec($useCase);
            }
        }
    }

    public function isVerifiedRequest(UseCase $useCase, BotApiRequest $request): bool
    {
        return $useCase->verify($request);
    }

    public function useCaseExec(UseCase $useCase)
    {
        $useCase->exec();
    }
}
