<?php

declare(strict_types=1);

namespace App\Factory;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class ApiClientFactory implements ApiClientFactoryInterface
{
    public function getClient(): ClientInterface
    {
        return new Client();
    }
}
