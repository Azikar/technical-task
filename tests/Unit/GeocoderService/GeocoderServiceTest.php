<?php

declare(strict_types=1);

namespace App\tests\Unit\GeocoderService;

use App\Entity\ResolvedAddress;
use App\Factory\CoordinatesFactory;
use App\Repository\ResolvedAddressRepository;
use App\Service\Geocode\Actions\GoogleGeocoderService;
use App\Service\Geocode\Actions\HereMapsGeocoderService;
use App\Service\Geocode\GeocodeService;
use App\Tests\TestData\Fixture\GeocoderServiceFixture;
use App\ValueObject\Address;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Service\Geocode\GeocodeService
 */
class GeocoderServiceTest extends KernelTestCase
{
    public function testRecordExixtInDatabase(): void
    {
        $builder = $this->getMockBuilder(ResolvedAddressRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getByAddress', 'saveResolvedAddress'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getByAddress')
            ->willReturn(
                (new ResolvedAddress())
                    ->setCountryCode('lt')
                    ->setCity('vilnius')
                    ->setPostcode('12345')
                    ->setStreet('street')
                    ->setLat('42.236')
                    ->setLng('42.236')
            );

        $builder->expects($this->never())
            ->method('saveResolvedAddress');

        $googleAction = $this->getMockBuilder(GoogleGeocoderService::class)
            ->disableOriginalConstructor()->getMock();

        $hereMapsAction = $this->getMockBuilder(HereMapsGeocoderService::class)
            ->disableOriginalConstructor()->getMock();

        $geocodeService =  new GeocodeService($builder, [$googleAction, $hereMapsAction], new CoordinatesFactory());

        self::assertEquals(GeocoderServiceFixture::getCoordinates(), $geocodeService->getAndSaveGeocode(new Address('lt', 'vilnius', 'street', '12345')));
    }

    public function testGoogleActionCalledOnce(): void
    {
        $builder = $this->getMockBuilder(ResolvedAddressRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getByAddress', 'saveResolvedAddress'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getByAddress')
            ->willReturn(null);

        $builder->expects($this->once())
            ->method('saveResolvedAddress');

        $googleAction = $this->getMockBuilder(GoogleGeocoderService::class)
            ->disableOriginalConstructor()->onlyMethods(['geocode'])->getMock();

        $googleAction->expects($this->once())
            ->method('geocode')
            ->willReturn(GeocoderServiceFixture::getCoordinates());

        $hereMapsAction = $this->getMockBuilder(HereMapsGeocoderService::class)
            ->disableOriginalConstructor()->onlyMethods(['geocode'])->getMock();

        $hereMapsAction->expects($this->never())->method('geocode')->willReturn(null);

        $geocodeService =  new GeocodeService($builder, [$googleAction, $hereMapsAction], new CoordinatesFactory());

        self::assertEquals(GeocoderServiceFixture::getCoordinates(), $geocodeService->getAndSaveGeocode(new Address('lt', 'vilnius', 'street', '12345')));
    }

    public function testHereMapsActionCalledOnce(): void
    {
        $repository = $this->getMockBuilder(ResolvedAddressRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getByAddress', 'saveResolvedAddress'])
            ->getMock();
        $repository->expects($this->once())
            ->method('getByAddress')
            ->willReturn(null);

        $repository->expects($this->once())
            ->method('saveResolvedAddress');

        $googleAction = $this->getMockBuilder(GoogleGeocoderService::class)
            ->disableOriginalConstructor()->onlyMethods(['geocode'])->getMock();

        $googleAction->expects($this->once())
            ->method('geocode')
            ->willReturn(null);

        $hereMapsAction = $this->getMockBuilder(HereMapsGeocoderService::class)
            ->disableOriginalConstructor()->onlyMethods(['geocode'])->getMock();

        $hereMapsAction->expects($this->once())->method('geocode')->willReturn(GeocoderServiceFixture::getCoordinates());

        $geocodeService =  new GeocodeService($repository, [$googleAction, $hereMapsAction], new CoordinatesFactory());

        self::assertEquals(GeocoderServiceFixture::getCoordinates(), $geocodeService->getAndSaveGeocode(new Address('lt', 'vilnius', 'street', '12345')));
    }
}
