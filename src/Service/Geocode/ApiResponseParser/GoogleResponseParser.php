<?php

declare(strict_types=1);

namespace App\Service\Geocode\ApiResponseParser;

use App\Factory\CoordinatesFactoryInterface;
use App\Service\Geocode\ApiHandler\GoogleHandler;
use App\Service\Geocode\ApiHandler\HandlerInterface;
use App\ValueObject\Coordinates;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class GoogleResponseParser implements ParserInterface
{
    private CoordinatesFactoryInterface $coordinatesFactory;

    public function __construct(CoordinatesFactoryInterface $coordinatesFactory)
    {
        $this->coordinatesFactory = $coordinatesFactory;
    }

    public function supports(HandlerInterface $class): bool
    {
        return $class instanceof GoogleHandler;
    }

    /**
     * @throws JsonException
     */
    public function parseResult(ResponseInterface $response): ?Coordinates
    {
        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($data['results']) === 0) {
            return null;
        }
        $firstResult = reset($data['results']);

        if (
            isset($firstResult['geometry']['location_type'])
            && $firstResult['geometry']['location_type'] !== 'ROOFTOP'
        ) {
            return null;
        }

        if (!isset($firstResult['geometry']['location']['lat'], $firstResult['geometry']['location']['lng'])) {
            return null;
        }

        return $this->coordinatesFactory->buildCoordinates(
            $firstResult['geometry']['location']['lat'],
            $firstResult['geometry']['location']['lng'],
        );
    }
}
