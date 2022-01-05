<?php
namespace Tests\Unit\UseCases;

use App\Domain\Entity\MessagingApi\MessagingApiRequest;
use App\Infrastructures\BotApi\MessagingApi;
use App\UseCases\UseCase;
use App\UseCases\UseCaseKernel;
use ReflectionException;
use Tests\TestCase;

class UseCaseKernelTest extends TestCase
{

    private UseCaseKernel $kernel;

    public function setUp(): void
    {
        parent::setUp();
        $this->kernel = new UseCaseKernel();
    }

    /**
     * @throws ReflectionException
     */
    public function test_getUseCases()
    {
        $useCases = $this->kernel->getUseCases(
            new MessagingApi(),
            new MessagingApiRequest(
                array(
                    'destination' => 'xxxxxxxxxx',
                    'events' => array(
                        array(
                            'type' => 'message',
                            'message' => array(
                                'type' => 'text',
                                'id' => '14353798921116',
                                'text' => 'Hello, world'
                            ),
                            'timestamp' => 1625665242211,
                            'source' => array(
                                'type' => 'user',
                                'userId' => 'U80696558e1aa831...'
                            ),
                            'replyToken' => '757913772c4646b784d4b7ce46d12671',
                            'mode' => 'active'
                        )
                    )
                )
            )
        );
        foreach ($useCases as $useCase) {
            // UseCaseのインスタンスであることを確認
            $this->assertInstanceOf(UseCase::class, $useCase);
        }

    }
}
