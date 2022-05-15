<?php

declare(strict_types=1);

namespace App\Service\Geocode\Actions;

use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;

interface GeocodeActionsInterface
{
    public static function getDefaultPriority(): int;

    public function geocode(AddressInterface $address): ?Coordinates;
}
