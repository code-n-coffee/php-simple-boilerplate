<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Infrastructure\Exceptions\BadGateway;
use CurlHandle;

class HttpClient
{
    private CurlHandle $ch;

    public function __construct()
    {
        $ch = curl_init();
        assert($ch instanceof CurlHandle);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->ch = $ch;
    }

    /**
     * @throws BadGateway
     */
    public function get(string $url): string
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);

        return $this->request($this->ch);
    }

    /**
     * @throws BadGateway
     */
    public function post(string $url, array $data): string
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));

        return $this->request($this->ch);
    }

    /**
     * @throws BadGateway
     */
    private function request(\CurlHandle|bool $ch): string
    {
        $output = curl_exec($ch);
        if ($output === false) {
            throw new BadGateway(curl_error($ch));
        }

        curl_close($ch);

        return $output;
    }
}
