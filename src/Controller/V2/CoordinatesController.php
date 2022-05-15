<?php

declare(strict_types=1);

namespace App\Controller\V2;

use App\Request\CoordinatesControllerRequest;
use App\Response\CoordinatesControllerResponse;
use App\Service\Geocode\Actions\GoogleGeocoderService;
use App\Service\Geocode\Actions\HereMapsGeocoderService;
use App\Service\Geocode\GeocodeServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @route("/v2")
 */
class CoordinatesController extends AbstractController
{
    private CoordinatesControllerRequest $coordinatesControllerRequest;

    private CoordinatesControllerResponse $coordinatesControllerResponse;

    public function __construct(
        CoordinatesControllerRequest $coordinatesControllerRequest,
        CoordinatesControllerResponse $coordinatesControllerResponse
    ) {
        $this->coordinatesControllerRequest = $coordinatesControllerRequest;
        $this->coordinatesControllerResponse = $coordinatesControllerResponse;
    }

    /**
     * @Route(path="/coordinates", name="v2geocode")
     * @throws Exception
     */
    public function geocodeAction(
        Request $request,
        GeocodeServiceInterface $geocodeService
    ): Response {
        return $this->coordinatesControllerResponse->parse(
            $geocodeService->getAndSaveGeocode($this->coordinatesControllerRequest->parseGeocoderAddress($request))
        );
    }

    /**
     * @Route(path="/gmaps", name="v2gmaps")
     */
    public function gmapsAction(Request $request, GoogleGeocoderService $googleGeocoderService): Response
    {
        return $this->coordinatesControllerResponse->parse(
            $googleGeocoderService->geocode($this->coordinatesControllerRequest->parse($request))
        );
    }

    /**
     * @Route(path="/hmaps", name="v2hmaps")
     */
    public function hmapsAction(Request $request, HereMapsGeocoderService $hereMapsGeocoderService): Response
    {
        return $this->coordinatesControllerResponse->parse(
            $hereMapsGeocoderService->geocode($this->coordinatesControllerRequest->parse($request))
        );
    }
}
