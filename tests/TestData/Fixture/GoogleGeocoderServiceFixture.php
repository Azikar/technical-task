<?php

declare(strict_types=1);

namespace App\Tests\TestData\Fixture;

use App\ValueObject\Coordinates;

class GoogleGeocoderServiceFixture
{
    public static function getGoogleApiResponse(): string
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

    public static function getCoordinates(): Coordinates
    {
        return new Coordinates(54.6878265, 25.2609295);
    }
}

