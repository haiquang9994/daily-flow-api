<?php

namespace App\Http;

use App\Http\Subscriber\CorsMiddlewareSubscriber;
use Pho\Http\Kernel as PhoKernel;

class Kernel extends PhoKernel
{
    public function stacks()
    {
    }

    public function events()
    {
        $this->subscribe(CorsMiddlewareSubscriber::class);
    }
}
