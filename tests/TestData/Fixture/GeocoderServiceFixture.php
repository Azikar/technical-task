<?php

declare(strict_types=1);

namespace App\Tests\TestData\Fixture;

use App\ValueObject\Coordinates;

class GeocoderServiceFixture
{
    public static function getCoordinates(): Coordinates
    {
        return new Coordinates(42.236, 42.236);
    }
}
