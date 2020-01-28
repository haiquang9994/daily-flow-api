<?php

namespace App\Http\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorsMiddlewareSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getMethod() === 'OPTIONS') {
            $response = new Response();
            $response->headers->set('Access-Control-Max-Age', '2592000');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $event->setResponse($response);
        } else {
            $response = $event->getResponse();
        }
        if ($origin = $request->headers->get('origin')) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 1024],
        ];
    }
}
