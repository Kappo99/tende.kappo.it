<?php

namespace App\Controllers;

use App\Common\BaseController;
use App\Dto\Request\RainSensorRequestDto;
use App\Dto\Request\RainSensorInsertRequestDto;
use App\Dto\Response\RainSensorResponseDto;
use App\Managers\RainSensorManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RainSensorController extends BaseController
{
    public function __construct(RainSensorManager $manager)
    {
        parent::__construct($manager);
    }

    /**
     * GET /api/rain-sensor
     */
    public function index(Request $request, Response $response): Response
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $requestDto = new RainSensorRequestDto($queryParams);

            $models = $this->manager->getByFilters(
                $requestDto->date,
                $requestDto->limit
            );

            $responseDtos = RainSensorResponseDto::fromArray($models);

            return $this->success($response, $responseDtos, 'Dati sensore pioggia recuperati con successo');
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }

    /**
     * POST /api/rain-sensor
     */
    public function insert(Request $request, Response $response): Response
    {
        try {
            $body = $request->getParsedBody();
            $requestDto = new RainSensorInsertRequestDto($body ?? []);

            if (!$requestDto->isValid()) {
                return $this->error($response, 'Dati non validi: gli array rain e date devono avere la stessa lunghezza', 400);
            }

            $result = $this->manager->insertBatch($requestDto->rain, $requestDto->date);

            if ($result) {
                return $this->success($response, null, 'Dati sensore pioggia inseriti con successo', 201);
            } else {
                return $this->error($response, 'Errore durante l\'inserimento dei dati', 500);
            }
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }
}
