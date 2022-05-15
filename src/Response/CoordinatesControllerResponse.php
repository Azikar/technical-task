<?php

declare(strict_types=1);

namespace App\Response;

use App\ValueObject\Coordinates;
use Symfony\Component\HttpFoundation\JsonResponse;

class CoordinatesControllerResponse
{
    public function parse(?Coordinates $coordinates): JsonResponse
    {
        if (null === $coordinates) {
            return new JsonResponse([]);
        }
        return new JsonResponse(['lat' => $coordinates->getLat(), 'lng' => $coordinates->getLng()]);
    }
}
