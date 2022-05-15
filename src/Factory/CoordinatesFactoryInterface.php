<?php

declare(strict_types=1);

namespace App\Factory;

use App\ValueObject\Coordinates;

interface CoordinatesFactoryInterface
{
    public function buildCoordinates(float $lat, float $lng): Coordinates;
}
