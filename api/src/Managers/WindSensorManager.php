<?php

namespace App\Managers;

use App\Common\BaseManager;
use App\Services\WindSensorService;

class WindSensorManager extends BaseManager
{
    public function __construct(WindSensorService $service)
    {
        parent::__construct($service);
    }

    /**
     * Gestisce la logica di business per trovare i dati del sensore vento
     */
    public function getByFilters(?string $date = null, ?int $minValue = null, ?int $limit = null): array
    {
        return $this->service->findByFilters($date, $minValue, $limit);
    }

    /**
     * Gestisce la logica di business per trovare valori consecutivi
     */
    public function getConsecutiveValues(string $date, int $consValue, int $min, int $max): array
    {
        return $this->service->findConsecutiveValues($date, $consValue, $min, $max);
    }

    /**
     * Gestisce l'inserimento di dati vento
     */
    public function insertBatch(array $frequency, array $dates): bool
    {
        return $this->service->insertBatch($frequency, $dates);
    }

    /**
     * Calcola i minuti dall'ultimo record
     */
    public function getMinutesFromLastRecord(): ?int
    {
        return $this->service->getMinutesFromLastRecord();
    }
}
