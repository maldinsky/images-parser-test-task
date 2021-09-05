<?php

namespace App;

use App\Services\ImagesParserService\ImagesParser;
use App\Services\ParserServiceInterface;
use App\Services\SaveImageService\SaveImageService;
use App\Services\SaveImageServiceInterface;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use function DI\autowire;

class Application
{
    public function handle(Request $request)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $router = new Router();
        $handlerInfo = $router->dispatch($request->getMethod(), $request->getRequestUri());

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            ParserServiceInterface::class => autowire(ImagesParser::class),
            SaveImageServiceInterface::class => autowire(SaveImageService::class )
                ->constructorParameter('saveImagesDirectory', $_ENV['SAVE_IMAGES_DIRECTORY']),
        ]);

        $container = $containerBuilder->build();
        $controller = $container->get($handlerInfo['handler']);

        return $controller->{$handlerInfo['method']}($request);
    }

}