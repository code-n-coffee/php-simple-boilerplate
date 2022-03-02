<?php

declare(strict_types=1);

use App\Infrastructure\Exceptions\HttpError;
use App\Infrastructure\Exceptions\UnhandledException;
use App\Infrastructure\Request;
use App\Infrastructure\Response;
use App\Infrastructure\Router\Router;
use App\Infrastructure\Services\Logger;

const __ROOT_DIR__ = __DIR__ . "/..";
const __VIEW_DIR__ = __ROOT_DIR__ . "/views";
const __ETC_DIR_   = __ROOT_DIR__ . "/etc";

include 'routes.php';

try {
    $request  = Request::make();
    $router = Router::getInstance();
    $response = $router->run($request);
} catch (HttpError $e) { // handled errors (like validations)
    if ($e->shouldLog()) {
        Logger::logException($e);
    }

    $response = Response::exception($e);
} catch (\Throwable $e) { // unhandled errors
    Logger::logException($e);

    $response = Response::exception(new UnhandledException(
        'An unexpected error occurred.',
        true,
        $e->getMessage(),
        $e
    ));
}

$response->render();
