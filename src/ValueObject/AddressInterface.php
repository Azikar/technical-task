<?php

declare(strict_types=1);

namespace App\ValueObject;

interface AddressInterface
{
    public function getCountry(): string;

    public function getCity(): string;

    public function getStreet(): string;

    public function getPostcode(): string;
}
