<?php

declare(strict_types=1);

namespace App\Service\Geocode;

use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;

interface GeocodeServiceInterface
{
    public function getAndSaveGeocode(AddressInterface $address): ?Coordinates;
}
