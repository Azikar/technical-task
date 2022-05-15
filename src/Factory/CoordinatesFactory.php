<?php

declare(strict_types=1);

namespace App\Factory;

use App\ValueObject\Coordinates;

class CoordinatesFactory implements CoordinatesFactoryInterface
{
    public function buildCoordinates(float $lat, float $lng): Coordinates
    {
        return new Coordinates($lat, $lng);
    }
}
