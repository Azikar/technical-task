<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ResolvedAddress;
use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;

interface ResolvedAddressRepositoryInterface
{
    public function getByAddress(AddressInterface $address): ?ResolvedAddress;

    public function saveResolvedAddress(AddressInterface $address, ?Coordinates $coordinates): void;
}
