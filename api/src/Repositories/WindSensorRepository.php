<?php

namespace App\Repositories;

use App\Common\BaseRepository;
use App\Models\WindSensor;

class WindSensorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('smart-home_wind-sensor', WindSensor::class);
    }

    /**
     * Trova i dati del sensore vento con filtri avanzati
     */
    public function findByFilters(?string $date = null, ?int $minValue = null, ?int $limit = null): array
    {
        $sql = "SELECT id, date, frequency FROM `{$this->tableName}`";
        $params = [];
        $where = [];

        if ($date !== null && $date !== '0') {
            $where[] = "date LIKE ?";
            $params[] = $date . '%';
        }

        if ($minValue !== null && $minValue > 0) {
            $where[] = "frequency >= ?";
            $params[] = $minValue;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY date DESC";

        if ($limit !== null && $limit > 0) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }

        return $this->query($sql, $params);
    }

    /**
     * Trova valori consecutivi per una data specifica
     */
    public function findConsecutiveValues(string $date, int $consValue, int $windMin, int $windMax): array
    {
        $sql = "SELECT id, date, frequency FROM `{$this->tableName}` WHERE date LIKE ? ORDER BY date DESC";
        $params = [$date . '%'];
        
        $results = $this->queryRaw($sql, $params);
        
        $consecutiveResults = [];
        $consecutiveCount = 0;
        
        foreach ($results as $row) {
            $frequency = (int)$row['frequency'];
            
            if ($frequency < $windMax) {
                if ($frequency >= $windMin) {
                    $consecutiveCount++;
                    if ($consecutiveCount == $consValue) {
                        $consecutiveResults[] = [
                            'id' => (int)$row['id'],
                            'date' => $row['date']
                        ];
                    }
                } else {
                    $consecutiveCount = 0;
                }
            }
        }
        
        return $consecutiveResults;
    }

    /**
     * Inserisce multipli record di dati vento
     */
    public function insertBatch(array $frequency, array $dates): bool
    {
        if (count($frequency) !== count($dates)) {
            throw new \InvalidArgumentException('Gli array frequency e date devono avere la stessa lunghezza');
        }

        $data = [];
        for ($i = 0; $i < count($frequency); $i++) {
            $data[] = [
                'date' => $dates[$i],
                'frequency' => (int)$frequency[$i]
            ];
        }

        return $this->insertBatchInternal($data, ['date', 'frequency']);
    }

    /**
     * Ottiene l'ultimo record inserito
     */
    public function getLastRecord(): ?WindSensor
    {
        $sql = "SELECT * FROM `{$this->tableName}` ORDER BY date DESC LIMIT 1";
        return $this->queryOne($sql);
    }
}
