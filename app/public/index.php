<?php

use App\Application;
use Symfony\Component\HttpFoundation\Request;

require '../vendor/autoload.php';

$app = new Application();
$response = $app->handle(Request::createFromGlobals());
$response->send();

