<?php

declare(strict_types=1);

namespace App\tests\Unit\ApiResponseParser;

use App\Service\Geocode\ApiResponseParser\GoogleResponseParser;
use App\Tests\TestData\Fixture\GoogleResponseParserFixture;
use App\Tests\TestData\Factory\GuzzleResponseFactory;
use App\ValueObject\Coordinates;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * @covers \App\Service\Geocode\ApiResponseParser\HereMapsResponseParser
 */
class GoogleResponseParserTest extends KernelTestCase
{
    private static ?GoogleResponseParser $hereMapsResponseParser;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$hereMapsResponseParser = self::$container->get(GoogleResponseParser::class);
    }

    /**
     * @dataProvider parserDataProvider
     * @throws JsonException
     */
    public function testParser(?Coordinates $expected, string $jsonResponse): void
    {
        self::assertEquals($expected, self::$hereMapsResponseParser->parseResult(GuzzleResponseFactory::create($jsonResponse)));
    }

    public function parserDataProvider(): array
    {
        return [
            'test coordinates success case' => [
                'expected' => GoogleResponseParserFixture::getCoordinates(),
                'jsonResponse' => GoogleResponseParserFixture::getParsableJsonResponse(),
            ],
            'test location type not ROOFTOP' => [
                'expected' => null,
                'jsonResponse' => GoogleResponseParserFixture::getIncorrectLocationTypeJsonResponse(),
            ],
            'test geometry not set' => [
                'expected' => null,
                'jsonResponse' => GoogleResponseParserFixture::getMissingGeometryJsonResponse(),
            ],
            'test 0 items' => [
                'expected' => null,
                'jsonResponse' => GoogleResponseParserFixture::getEmptyJsonResponse(),
            ]
        ];
    }
}
