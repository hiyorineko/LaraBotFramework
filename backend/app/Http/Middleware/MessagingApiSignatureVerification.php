<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MessagingApiSignatureVerification
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $entityBody = file_get_contents('php://input');
        if (strlen($entityBody) === 0) {
            http_response_code(400);
            error_log("Missing request body");
            exit();
        }

        if (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {
            http_response_code(400);
            error_log("Invalid signature value");
            exit();
        }

        $data = json_decode($entityBody, true);
        if (!isset($data['events'])) {
            http_response_code(400);
            error_log("Invalid request body: missing events property");
            exit();
        }
        return $next($request);
    }

    private function sign($body): string
    {
        $hash = hash_hmac('sha256', $body, config('messagingApi.channel_secret'), true);
        return base64_encode($hash);
    }
}
