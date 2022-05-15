<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\Geocode\ApiHandler\HandlerInterface;
use App\Service\Geocode\ApiResponseParser\ParserInterface;
use App\ValueObject\Coordinates;
use Exception;
use Psr\Http\Message\ResponseInterface;

class GeocodeApiResponseParserFactory
{
    private iterable $parsers;

    /**
     * @param iterable<ParserInterface> $parsers
     */
    public function __construct(iterable $parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * @throws Exception
     */
    public function execute(HandlerInterface $handler, ResponseInterface $response): ?Coordinates
    {
        foreach ($this->parsers as $parser) {
            if ($parser->supports($handler))
            {
                return $parser->parseResult($response);
            }
        }

        throw new Exception(sprintf('parser is not supported for %s handler', get_class($handler)));
    }
}
