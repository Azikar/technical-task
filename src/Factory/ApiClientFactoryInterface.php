<?php

declare(strict_types=1);

namespace App\Factory;

use Psr\Http\Client\ClientInterface;

interface ApiClientFactoryInterface
{
    public function getClient(): ClientInterface;
}
