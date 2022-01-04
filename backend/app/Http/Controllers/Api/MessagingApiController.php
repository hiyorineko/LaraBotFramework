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
     * @throws ReflectionException
     */
    public function webhook(Request $request)
    {
        $requestEntity = $this->repository->getRequestEntity($request->input());
        $this->response->actionRouter($requestEntity);
    }
}
