<?php

declare(strict_types=1);

namespace App\Factory;

use GuzzleHttp\Client;

class ApiClientFactory implements ApiClientFactoryInterface
{
    public function getClient(): Client
    {
        return new Client();
    }
}
