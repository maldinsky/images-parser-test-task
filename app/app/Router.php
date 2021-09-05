<?php

namespace App;

use App\Http\Controllers\v1\ParseImageController;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = simpleDispatcher(function(RouteCollector $r) {
            $r->addRoute('POST', '/api/v1/parse-image', [ParseImageController::class, 'handle']);
        });
    }

    public function dispatch(string $httpMethod, string $uri): array
    {
        $uri = $this->prepareUri($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $handler = [
                    'result' => Dispatcher::NOT_FOUND,
                    'handler' => null,
                    'method' => null,
                ];
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $handler = [
                    'result' => Dispatcher::METHOD_NOT_ALLOWED,
                    'handler' => null,
                    'method' => null,
                ];
                break;
            case Dispatcher::FOUND:
                $handler = [
                    'result' => Dispatcher::FOUND,
                    'handler' => $routeInfo[1][0] ?? null,
                    'method' => $routeInfo[1][1] ?? null,
                ];
                break;
            default:
                $handler = [
                    'result' => Dispatcher::NOT_FOUND,
                    'handler' => null,
                    'method' => null,
                ];
        }

        return $handler;
    }

    private function prepareUri(string $uri): string
    {
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        return rawurldecode($uri);
    }
}