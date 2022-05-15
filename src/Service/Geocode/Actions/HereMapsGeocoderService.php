<?php

declare(strict_types=1);

namespace App\Service\Geocode\Actions;

use App\Factory\GeocodeApiResponseParserFactory;
use App\Service\Geocode\ApiHandler\HandlerInterface;
use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class HereMapsGeocoderService implements GeocodeActionsInterface
{
    private HandlerInterface $apiAdapter;
    private GeocodeApiResponseParserFactory $geocodeApiResponseParserFactory;

    public function __construct(
        HandlerInterface $apiAdapter,
        GeocodeApiResponseParserFactory $geocodeApiResponseParserFactory
    )
    {
        $this->apiAdapter = $apiAdapter;
        $this->geocodeApiResponseParserFactory = $geocodeApiResponseParserFactory;
    }

    public static function getDefaultPriority(): int
    {
        return 3;
    }

    public function geocode(AddressInterface $address): ?Coordinates
    {
        try {
            return $this->geocodeApiResponseParserFactory->execute(
                $this->apiAdapter,
                $this->apiAdapter->getGeocoding($address)
            );
        } catch (GuzzleException|Exception $exception) {
            //Handle exception

            return null;
        }
    }
}
