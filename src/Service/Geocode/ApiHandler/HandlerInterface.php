<?php

declare(strict_types=1);

namespace App\Service\Geocode\ApiHandler;

use App\ValueObject\AddressInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

interface HandlerInterface
{
    /**
     * @throws GuzzleException
     */
    public function getGeocoding(AddressInterface $address): ResponseInterface;
}
