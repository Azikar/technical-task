<?php

declare(strict_types=1);

namespace App\Request;

use App\ValueObject\Address;
use App\ValueObject\GeocoderAddress;
use Doctrine\Inflector\Inflector;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CoordinatesControllerRequest
{
    public function __construct(ValidatorInterface $validator)
    {
    }

    public function parse(Request $request): Address
    {
        $country = $request->get('countryCode', 'lt');
        $city = $request->get('city', 'vilnius');
        $street = $request->get('street', 'jasinskio 16');
        $postcode = $request->get('postcode', '01112');

        return new Address($country, $city, $street, $postcode);
    }

    /**
     * @throws Exception
     */
    public function parseGeocoderAddress(Request $request): GeocoderAddress
    {
        $country = $request->get('countryCode', 'lt');
        $city = $request->get('city', 'vilnius');
        $street = $request->get('street', 'jasinskio 16');
        $postcode = $request->get('postcode', '01112');

        $address = new GeocoderAddress($country, $city, $street, $postcode);

        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($address);
        if ($errors->count() > 0) {
            //should add hernel exception handler to build responses
            throw new Exception($this->createErrorMessage($errors), Response::HTTP_BAD_REQUEST, null);
        }

        return $address;
    }

    /**
     * @throws JsonException
     */
    private function createErrorMessage(ConstraintViolationListInterface $violations): string
    {
        $errors = [];

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errors[Inflector::tableize($violation->getPropertyPath())] = $violation->getMessage();
        }

        return json_encode(['errors' => $errors], JSON_THROW_ON_ERROR);
    }
}
