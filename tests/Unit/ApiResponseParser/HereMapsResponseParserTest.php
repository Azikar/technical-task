<?php

declare(strict_types=1);

namespace App\tests\Unit\ApiResponseParser;

use App\Service\Geocode\ApiResponseParser\HereMapsResponseParser;
use App\Tests\TestData\Factory\GuzzleResponseFactory;
use App\Tests\TestData\Fixture\HereMapsResponseParserFixtures;
use App\ValueObject\Coordinates;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * @covers \App\Service\Geocode\ApiResponseParser\HereMapsResponseParser
 */
class HereMapsResponseParserTest extends KernelTestCase
{
    private static ?HereMapsResponseParser $hereMapsResponseParser;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$hereMapsResponseParser = self::$container->get(HereMapsResponseParser::class);
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
                'expected' => HereMapsResponseParserFixtures::getCoordinates(),
                'jsonResponse' => HereMapsResponseParserFixtures::getParsableJsonResponse(),
            ],
            'test not house number case' => [
                'expected' => null,
                'jsonResponse' => HereMapsResponseParserFixtures::getNotHouseNumberJsonResponse(),
            ],
            'test 0 items' => [
                'expected' => null,
                'jsonResponse' => HereMapsResponseParserFixtures::getEmptyJsonResponse(),
            ]
        ];
    }
}
