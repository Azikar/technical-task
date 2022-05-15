<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

class GeocoderAddress implements AddressInterface
{
    /**
     * @Assert\Length(max=3)
     */
    private string $country;

    /**
     * @Assert\Length(max=255)
     */
    private string $city;

    /**
     * @Assert\Length(max=255)
     */
    private string $street;

    /**
     * @Assert\Length(max=16)
     */
    private string $postcode;

    public function __construct(string $country, string $city, string $street, string $postcode)
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->postcode = $postcode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }
}
