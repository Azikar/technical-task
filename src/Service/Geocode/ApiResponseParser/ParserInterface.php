<?php

declare(strict_types=1);

namespace App\Service\Geocode\ApiResponseParser;

use App\Service\Geocode\ApiHandler\HandlerInterface;
use App\ValueObject\Coordinates;
use Psr\Http\Message\ResponseInterface;

interface ParserInterface
{
    public function supports(HandlerInterface $class): bool;

    public function parseResult(ResponseInterface $response): ?Coordinates;
}
