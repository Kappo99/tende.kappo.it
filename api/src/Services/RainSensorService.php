<?php

namespace App\Services;

use App\Common\BaseService;
use App\Repositories\RainSensorRepository;

class RainSensorService extends BaseService
{
    public function __construct(RainSensorRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Trova i dati del sensore pioggia con filtri
     */
    public function findByFilters(?string $date = null, ?int $limit = null): array
    {
        return $this->repository->findByFilters($date, $limit);
    }

    /**
     * Inserisce multipli record di dati pioggia
     */
    public function insertBatch(array $rain, array $dates): bool
    {
        return $this->repository->insertBatch($rain, $dates);
    }
}
