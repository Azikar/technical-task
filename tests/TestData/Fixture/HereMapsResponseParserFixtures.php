<?php

declare(strict_types=1);

namespace App\tests\TestData\Fixture;

use App\ValueObject\Coordinates;

class HereMapsResponseParserFixtures
{
    public static function getCoordinates(): Coordinates
    {
        return new Coordinates(54.68591, 25.26102);
    }

    public static function getParsableJsonResponse(): string
    {
        return '{"items":[{"title":"01112, Vilnius, Vilniaus Apskritis, Lietuva","id":"here:cm:namedplace:23293605-23292354","resultType":"houseNumber","localityType":"postalCode","address":{"label":"01112, Vilnius, Vilniaus Apskritis, Lietuva","countryCode":"LTU","countryName":"Lietuva","state":"Vilniaus Apskritis","county":"Vilniaus Miesto savivaldybė","city":"Vilnius","postalCode":"01112"},"position":{"lat":54.68591,"lng":25.26102},"mapView":{"west":25.25545,"south":54.68255,"east":25.26781,"north":54.68921},"scoring":{"queryScore":0.67,"fieldScore":{"country":1.0,"city":1.0,"postalCode":1.0}}}]}';
    }

    public static function getNotHouseNumberJsonResponse(): string
    {
        return '{"items":[{"title":"01112, Vilnius, Vilniaus Apskritis, Lietuva","id":"here:cm:namedplace:23293605-23292354","resultType":"notHouseNumber","localityType":"postalCode","address":{"label":"01112, Vilnius, Vilniaus Apskritis, Lietuva","countryCode":"LTU","countryName":"Lietuva","state":"Vilniaus Apskritis","county":"Vilniaus Miesto savivaldybė","city":"Vilnius","postalCode":"01112"},"position":{"lat":54.68591,"lng":25.26102},"mapView":{"west":25.25545,"south":54.68255,"east":25.26781,"north":54.68921},"scoring":{"queryScore":0.67,"fieldScore":{"country":1.0,"city":1.0,"postalCode":1.0}}}]}';
    }

    public static function getEmptyJsonResponse(): string
    {
        return '{"items":[]}';
    }
}
