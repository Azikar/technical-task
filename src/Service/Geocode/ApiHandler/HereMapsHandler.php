<?php

declare(strict_types=1);

namespace App\Service\Geocode\ApiHandler;

use App\Factory\ApiClientFactoryInterface;
use App\ValueObject\AddressInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HereMapsHandler implements HandlerInterface
{
    private string $key;

    private ApiClientFactoryInterface $apiClientFactory;

    private string $apiUrl;

    public function __construct(
        string $key,
        ApiClientFactoryInterface $apiClientFactory,
        string $apiUrl
    ) {
        $this->key = $key;
        $this->apiClientFactory = $apiClientFactory;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @throws GuzzleException
     */
    public function getGeocoding(AddressInterface $address, bool $validateLocation = true): ResponseInterface
    {
        try {
            return $this->executeGetRequest($this->getRequest($address));
        } catch (GuzzleException $exception) {
            //could log issue or add some sort of handler.
            throw new $exception;
        }
    }

    /**
     * @throws GuzzleException
     */
    private function executeGetRequest(array $request): ResponseInterface
    {
        try {
            return $this->apiClientFactory->getClient()->get($this->apiUrl, $request);
        } catch (GuzzleException $exception) {
            //could log issue or add some sort of handler.
            throw new $exception;
        }
    }

    private function getRequest(AddressInterface $address): array
    {
        return [
            'query' => [
                'qq' => implode(';', [
                    "country={$address->getCountry()}",
                    "city={$address->getCity()}",
                    "street={$address->getCity()}",
                    "postalCode={$address->getPostcode()}"
                ]),
                'apiKey' => $this->key
            ]
        ];
    }
}
