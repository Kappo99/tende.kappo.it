<?php

namespace App\Managers;

use App\Common\BaseManager;
use App\Services\RainSensorService;

class RainSensorManager extends BaseManager
{
    public function __construct(RainSensorService $service)
    {
        parent::__construct($service);
    }

    /**
     * Gestisce la logica di business per trovare i dati del sensore pioggia
     */
    public function getByFilters(?string $date = null, ?int $limit = null): array
    {
        return $this->service->findByFilters($date, $limit);
    }

    /**
     * Gestisce l'inserimento di dati pioggia
     */
    public function insertBatch(array $rain, array $dates): bool
    {
        return $this->service->insertBatch($rain, $dates);
    }
}
