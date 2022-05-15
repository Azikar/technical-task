<?php

declare(strict_types=1);

namespace App\tests\Unit\GeocoderActions;

use App\Factory\CoordinatesFactory;
use App\Factory\GeocodeApiResponseParserFactory;
use App\Service\Geocode\Actions\GoogleGeocoderService;
use App\Service\Geocode\ApiHandler\GoogleHandler;
use App\Service\Geocode\ApiResponseParser\GoogleResponseParser;
use App\Tests\TestData\Factory\GuzzleResponseFactory;
use App\Tests\TestData\Fixture\GoogleGeocoderServiceFixture;
use App\ValueObject\Address;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Service\Geocode\Actions\GoogleGeocoderService
 */
class GoogleGeocoderServiceTest extends KernelTestCase
{
    public function testGeocode(): void
    {
        self::assertEquals(
            GoogleGeocoderServiceFixture::getCoordinates(),
            $this->mockGoogleGeocoderService()->geocode(new Address('lt', 'vilnius', 'street', '12345'))
        );
    }

    public function mockGoogleGeocoderService(): GoogleGeocoderService
    {
        $handler = $this->getMockBuilder(GoogleHandler::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getGeocoding'])
            ->getMock();
        $handler
            ->expects($this->once())
            ->method('getGeocoding')
            ->willReturn(GuzzleResponseFactory::create(GoogleGeocoderServiceFixture::getGoogleApiResponse()));

        return new GoogleGeocoderService(
            $handler,
            new GeocodeApiResponseParserFactory([new GoogleResponseParser(new CoordinatesFactory())])
        );
    }
}
