<?php

declare(strict_types=1);

namespace App\tests\TestData\Fixture;

use App\ValueObject\Coordinates;

class GoogleResponseParserFixture
{
    public static function getCoordinates(): Coordinates
    {
        return new Coordinates(54.6878265, 25.2609295);
    }

    public static function getParsableJsonResponse(): string
    {
        return '{
           "results":[
              {
                 "geometry":{
                    "location":{
                       "lat":54.6878265,
                       "lng":25.2609295
                    },
                    "location_type":"ROOFTOP"
                 },
                 "types":[
                    "street_address"
                 ]
              }
           ],
           "status":"OK"
        }';
    }

    public static function getIncorrectLocationTypeJsonResponse(): string
    {
        return '{
           "results":[
              {
                 "geometry":{
                    "location":{
                       "lat":54.6878265,
                       "lng":25.2609295
                    },
                    "location_type":"BAD_TYPE"
                 },
                 "types":[
                    "street_address"
                 ]
              }
           ],
           "status":"OK"
        }';
    }

    public static function getMissingGeometryJsonResponse(): string
    {
        return '{
           "results":[
              {
                 "geometry":{
                    "location_type":"ROOFTOP"
                 },
                 "types":[
                    "street_address"
                 ]
              }
           ],
           "status":"OK"
        }';
    }

    public static function getEmptyJsonResponse(): string
    {
        return '{"results":[]}';
    }
}
