<?php

declare(strict_types=1);

namespace App\Tests\TestData\Factory;

use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Response as Http;

class GuzzleResponseFactory
{
    public static function create(string $content, int $responseCode = Http::HTTP_OK): Response
    {
        return new Response($responseCode, ['Content-Type' => 'application/json'], $content);
    }
}
