<?php

namespace App\Services;

use App\Common\BaseService;
use App\Repositories\WindSensorRepository;

class WindSensorService extends BaseService
{
    public function __construct(WindSensorRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Trova i dati del sensore vento con filtri
     */
    public function findByFilters(?string $date = null, ?int $minValue = null, ?int $limit = null): array
    {
        return $this->repository->findByFilters($date, $minValue, $limit);
    }

    /**
     * Trova valori consecutivi
     */
    public function findConsecutiveValues(string $date, int $consValue, int $windMin, int $windMax): array
    {
        return $this->repository->findConsecutiveValues($date, $consValue, $windMin, $windMax);
    }

    /**
     * Inserisce multipli record di dati vento
     */
    public function insertBatch(array $frequency, array $dates): bool
    {
        return $this->repository->insertBatch($frequency, $dates);
    }

    /**
     * Ottiene l'ultimo record inserito
     */
    public function getLastRecord(): ?object
    {
        return $this->repository->getLastRecord();
    }

    /**
     * Calcola i minuti dall'ultimo record
     */
    public function getMinutesFromLastRecord(): ?int
    {
        $lastRecord = $this->repository->getLastRecord();
        if ($lastRecord === null) {
            return null;
        }

        date_default_timezone_set("Europe/Rome");
        $now = time();
        $lastDate = strtotime($lastRecord->date);
        
        return (int)round(abs($now - $lastDate) / 60);
    }
}
