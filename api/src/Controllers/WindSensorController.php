<?php

namespace App\Controllers;

use App\Common\BaseController;
use App\Dto\Request\WindSensorRequestDto;
use App\Dto\Request\WindSensorInsertRequestDto;
use App\Dto\Request\ConsecutiveValuesRequestDto;
use App\Dto\Response\WindSensorResponseDto;
use App\Dto\Response\ConsecutiveValueResponseDto;
use App\Managers\WindSensorManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class WindSensorController extends BaseController
{
    public function __construct(WindSensorManager $manager)
    {
        parent::__construct($manager);
    }

    /**
     * GET /api/wind-sensor
     */
    public function index(Request $request, Response $response): Response
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $requestDto = new WindSensorRequestDto($queryParams);

            $models = $this->manager->getByFilters(
                $requestDto->date,
                $requestDto->minValue,
                $requestDto->limit
            );

            $responseDtos = WindSensorResponseDto::fromArray($models);

            return $this->success($response, $responseDtos, 'Dati sensore vento recuperati con successo');
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }

    /**
     * GET /api/wind-sensor/consecutive-values
     */
    public function consecutiveValues(Request $request, Response $response): Response
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $requestDto = new ConsecutiveValuesRequestDto($queryParams);

            if ($requestDto->consValue === null || $requestDto->consValue <= 0) {
                return $this->error($response, 'Il parametro cons-value è obbligatorio e deve essere maggiore di 0', 400);
            }

            $date = $requestDto->date ?? date('Y-m-d');
            $results = $this->manager->getConsecutiveValues(
                $date,
                $requestDto->consValue,
                $requestDto->windMin,
                $requestDto->windMax
            );

            $responseDtos = ConsecutiveValueResponseDto::fromArray($results);

            return $this->success($response, $responseDtos, 'Valori consecutivi recuperati con successo');
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }

    /**
     * POST /api/wind-sensor
     */
    public function insert(Request $request, Response $response): Response
    {
        try {
            $body = $request->getParsedBody();
            $requestDto = new WindSensorInsertRequestDto($body ?? []);

            if (!$requestDto->isValid()) {
                return $this->error($response, 'Dati non validi: gli array frequency e date devono avere la stessa lunghezza', 400);
            }

            $result = $this->manager->insertBatch($requestDto->frequency, $requestDto->date);

            if ($result) {
                return $this->success($response, null, 'Dati sensore vento inseriti con successo', 201);
            } else {
                return $this->error($response, 'Errore durante l\'inserimento dei dati', 500);
            }
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }

    /**
     * GET /api/wind-sensor/minutes
     */
    public function minutes(Request $request, Response $response): Response
    {
        try {
            $minutes = $this->manager->getMinutesFromLastRecord();

            if ($minutes === null) {
                return $this->error($response, 'Nessun record trovato', 404);
            }

            return $this->success($response, ['minutes' => $minutes], 'Minuti calcolati con successo');
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }
}
