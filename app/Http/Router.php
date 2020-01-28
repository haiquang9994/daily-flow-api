<?php

namespace App\Http;

use App\Http\Middleware\ApiMiddleware;
use Pho\Routing\RouteLoader;
use Pho\Routing\Routing;

class Router extends RouteLoader
{
    private function to($controller, $method)
    {
        return '\\App\\Http\Controller\\'.$controller.'Controller::'.$method;
    }

    public function routes(Routing $routing)
    {
        $routing->get('/', $this->to('Home', 'index'), 'home');

        $routing->group('/api/v1', function ($group) {
            $group->map('GET|POST', '/daily-flow', $this->to('Main', 'index'), 'api_daily_flow');
            $group->map('GET|PUT|DELETE', '/daily-flow/{id}', $this->to('Main', 'index'), 'api_daily_flow_');
        }, [
            '_before' => [
                ApiMiddleware::class,
            ],
        ]);
    }
}
