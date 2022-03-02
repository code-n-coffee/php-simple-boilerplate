<?php

declare(strict_types=1);

use App\Controllers\LoginController;
use App\Infrastructure\Response;
use App\Infrastructure\Router\Router;

Router::get('/', fn() => Response::view('app.html'), 'index');
Router::post('/auth', LoginController::class, 'auth');
