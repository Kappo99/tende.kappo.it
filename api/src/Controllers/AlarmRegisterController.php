<?php

namespace App\Controllers;

use App\Common\BaseController;
use App\Dto\Request\AlarmRegisterRequestDto;
use App\Dto\Request\AlarmRegisterInsertRequestDto;
use App\Dto\Response\AlarmRegisterResponseDto;
use App\Managers\AlarmRegisterManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlarmRegisterController extends BaseController
{
    public function __construct(AlarmRegisterManager $manager)
    {
        parent::__construct($manager);
    }

    /**
     * GET /api/alarm-register
     */
    public function index(Request $request, Response $response): Response
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $requestDto = new AlarmRegisterRequestDto($queryParams);

            $models = $this->manager->getByFilters(
                $requestDto->date,
                $requestDto->limit
            );

            $responseDtos = AlarmRegisterResponseDto::fromArray($models);

            return $this->success($response, $responseDtos, 'Dati registro allarmi recuperati con successo');
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }

    /**
     * POST /api/alarm-register
     */
    public function insert(Request $request, Response $response): Response
    {
        try {
            $body = $request->getParsedBody();
            $requestDto = new AlarmRegisterInsertRequestDto($body ?? []);

            if (!$requestDto->isValid()) {
                return $this->error($response, 'Dati non validi: idAlarm è obbligatorio', 400);
            }

            $result = $this->manager->insertAlarm($requestDto->idAlarm);

            if (!$result['success']) {
                return $this->error($response, 'Errore durante l\'inserimento dell\'allarme', 500);
            }

            // Se l'allarme non è attivo (troppo presto dall'ultimo), restituisci solo i minuti
            if (!$result['active']) {
                return $this->success($response, [
                    'minutes' => $result['minutes'],
                    'active' => false,
                    'message' => 'Allarme registrato ma non attivato (troppo presto dall\'ultimo)'
                ], 'Allarme registrato');
            }

            // Qui potresti aggiungere la logica per inviare notifiche
            // Per ora restituiamo solo il risultato
            return $this->success($response, [
                'minutes' => $result['minutes'],
                'active' => true,
                'date' => $result['date'],
                'shouldNotify' => true
            ], 'Allarme inserito e attivato con successo', 201);
        } catch (\Exception $e) {
            return $this->error($response, $e->getMessage(), 500);
        }
    }
}
