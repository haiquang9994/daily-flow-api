<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    public function __invoke(Request $request)
    {
        $authorization = $request->headers->get('authorization');
        preg_match("/Bearer (.*)/", $authorization, $matchs);
        $token = $matchs[1] ?? null;
        if ($token === null) {
            $token = $request->query->get('_token');
        }
        if (is_string($token) && $token === env('SECRET_TOKEN', 'there is no secret token')) {
            return;
        }
        return new JsonResponse([
            'message' => 'Who are you?'
        ], Response::HTTP_FORBIDDEN);
    }
}
