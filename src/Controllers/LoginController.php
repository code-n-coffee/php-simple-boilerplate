<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Infrastructure\Exceptions\BadRequest;
use App\Infrastructure\Request;
use App\Infrastructure\Response;

class LoginController
{
    /**
     * @throws BadRequest
     */
    public function auth(Request $request): Response
    {
        $data = $request->getParsedBody();
        $this->validate($data);

        $success = $data['email'] === 'test@test.com' && $data['password'] === 'password';

        return Response::json(['success' => $success]);
    }

    /**
     * @throws BadRequest
     */
    private function validate(array $data): void
    {
        if (!isset($data['email']) || $data['email'] === '') {
            throw new BadRequest('Email is required and can\'t be empty.');
        }

        if (!isset($data['password']) || $data['password'] === '') {
            throw new BadRequest('Password is required and can\'t be empty.');
        }
    }
}
