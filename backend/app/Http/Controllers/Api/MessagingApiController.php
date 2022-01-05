<?php
namespace App\Http\Controllers\Api;

use App\Domain\Entity\MessagingApi\MessagingApiResponse;
use App\Http\Controllers\Controller;
use App\Infrastructures\Repositories\MessagingApiWebhookEventRepository;
use Illuminate\Http\Request;
use ReflectionException;

class MessagingApiController extends Controller
{
    private MessagingApiWebhookEventRepository $repository;
    private MessagingApiResponse $response;

    function __construct(MessagingApiWebhookEventRepository $repository, MessagingApiResponse $response) {
        $this->repository = $repository;
        $this->response = $response;
    }

    /**
     * MessagingApi webhook
     * Requestをデータストアに登録
     * Requestに応じてUseCaseを実行する
     * @throws ReflectionException
     */
    public function webhook(Request $request)
    {
        $this->repository->storeRequest($request->input());
        $requestEntity = $this->repository->getRequestEntity($request->input());
        $this->response->useCaseRouter($requestEntity);
    }
}
