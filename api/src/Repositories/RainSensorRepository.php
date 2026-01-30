<?php

namespace App\Repositories;

use App\Common\BaseRepository;
use App\Models\RainSensor;

class RainSensorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('smart-home_rain-sensor', RainSensor::class);
    }

    /**
     * Trova i dati del sensore pioggia con filtri
     */
    public function findByFilters(?string $date = null, ?int $limit = null): array
    {
        $sql = "SELECT id, date, rain FROM `{$this->tableName}`";
        $params = [];
        $where = [];

        if ($date !== null && $date !== '0') {
            $where[] = "date LIKE ?";
            $params[] = $date . '%';
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
     * Inserisce multipli record di dati pioggia
     */
    public function insertBatch(array $rain, array $dates): bool
    {
        if (count($rain) !== count($dates)) {
            throw new \InvalidArgumentException('Gli array rain e date devono avere la stessa lunghezza');
        }

        $data = [];
        for ($i = 0; $i < count($rain); $i++) {
            $data[] = [
                'date' => $dates[$i],
                'rain' => (bool)$rain[$i] ? 1 : 0
            ];
        }

        return $this->insertBatchInternal($data, ['date', 'rain']);
    }
}
