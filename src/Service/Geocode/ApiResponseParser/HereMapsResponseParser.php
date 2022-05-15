<?php

declare(strict_types=1);

namespace App\Service\Geocode\ApiResponseParser;

use App\Factory\CoordinatesFactoryInterface;
use App\Service\Geocode\ApiHandler\HandlerInterface;
use App\Service\Geocode\ApiHandler\HereMapsHandler;
use App\ValueObject\Coordinates;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class HereMapsResponseParser implements ParserInterface
{
    private CoordinatesFactoryInterface $coordinatesFactory;

    public function __construct(CoordinatesFactoryInterface $coordinatesFactory)
    {
        $this->coordinatesFactory = $coordinatesFactory;
    }

    public function supports(HandlerInterface $class): bool
    {
        return $class instanceof HereMapsHandler;
    }

    /**
     * @throws JsonException
     */
    public function parseResult(ResponseInterface $response): ?Coordinates
    {
        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        if (count($data['items']) === 0) {
            return null;
        }

        $firstItem = reset($data['items']);

        if ($firstItem['resultType'] !== 'houseNumber') {
            return null;
        }

        return $this->coordinatesFactory->buildCoordinates(
            $firstItem['position']['lat'],
            $firstItem['position']['lng'],
        );
    }
}
