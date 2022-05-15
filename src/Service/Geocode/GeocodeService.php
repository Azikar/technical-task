<?php

declare(strict_types=1);

namespace App\Service\Geocode;

use App\Factory\CoordinatesFactory;
use App\Repository\ResolvedAddressRepositoryInterface;
use App\Service\Geocode\Actions\GeocodeActionsInterface;
use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;

class GeocodeService implements GeocodeServiceInterface
{
    private ResolvedAddressRepositoryInterface $resolvedAddressRepository;

    private iterable $geocodeActions;

    private CoordinatesFactory $coordinatesFactory;

    /**
     * @param iterable<GeocodeActionsInterface> $geocodeActions
     */
    public function __construct(
        ResolvedAddressRepositoryInterface $resolvedAddressRepository,
        iterable $geocodeActions,
        CoordinatesFactory $coordinatesFactory
    ) {
        $this->resolvedAddressRepository = $resolvedAddressRepository;
        $this->geocodeActions = $geocodeActions;
        $this->coordinatesFactory = $coordinatesFactory;
    }

    public function getAndSaveGeocode(AddressInterface $address): ?Coordinates
    {
        $addressResult = $this->resolvedAddressRepository->getByAddress($address);
        if ($addressResult !== null) {
            if ($addressResult->getLng() !== null && $addressResult->getLat() !== null) {
                return $this->coordinatesFactory->buildCoordinates(
                    (float) $addressResult->getLat(),
                    (float) $addressResult->getLng()
                );
            }

            return null;
        }

        $coordinates = null;
        foreach ($this->geocodeActions as $geocodeAction) {
            $coordinates = $geocodeAction->geocode($address);
            if ($coordinates !== null) {
                break;
            }
        }

        $this->resolvedAddressRepository->saveResolvedAddress($address, $coordinates);

        return $coordinates;
    }
}
