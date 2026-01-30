<?php

namespace App\Common;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    protected BaseManager $manager;

    public function __construct(BaseManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Restituisce una risposta JSON di successo
     */
    protected function success(Response $response, $data = null, string $message = 'Operazione eseguita con successo', int $code = 200): Response
    {
        $payload = [
            'code' => $code,
            'message' => $message,
        ];

        if ($data !== null) {
            $payload['data'] = $data;
        }

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }

    /**
     * Restituisce una risposta JSON di errore
     */
    protected function error(Response $response, string $message = 'Errore durante l\'operazione', int $code = 400, array $errors = []): Response
    {
        $payload = [
            'code' => $code,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }

    /**
     * Estrae i parametri di query dalla richiesta
     */
    protected function getQueryParams(Request $request): array
    {
        return $request->getQueryParams();
    }
}
