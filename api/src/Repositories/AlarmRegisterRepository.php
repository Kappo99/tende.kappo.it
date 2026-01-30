<?php

namespace App\Repositories;

use App\Common\BaseRepository;
use App\Models\AlarmRegister;

class AlarmRegisterRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('smart-home_alarm-register', AlarmRegister::class);
    }

    /**
     * Trova i dati del registro allarmi con JOIN alla tabella alarm-type
     */
    public function findByFilters(?string $date = null, ?int $limit = null): array
    {
        $sql = "SELECT `{$this->tableName}`.id AS id, date, alarm, active 
                FROM `{$this->tableName}` 
                INNER JOIN `smart-home_alarm-type` ON `{$this->tableName}`.idAlarm = `smart-home_alarm-type`.id";
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

        $results = $this->queryRaw($sql, $params);
        
        $items = [];
        foreach ($results as $row) {
            $items[] = new AlarmRegister([
                'id' => (int)$row['id'],
                'date' => $row['date'],
                'alarm' => $row['alarm'],
                'active' => (bool)$row['active']
            ]);
        }
        
        return $items;
    }

    /**
     * Inserisce un nuovo allarme nel registro
     */
    public function insertAlarm(int $idAlarm, string $date, bool $active): bool
    {
        $data = [
            'date' => $date,
            'idAlarm' => $idAlarm,
            'active' => $active ? 1 : 0
        ];

        return $this->insert($data);
    }

    /**
     * Ottiene l'ultimo allarme attivo
     */
    public function getLastActiveAlarm(): ?AlarmRegister
    {
        $sql = "SELECT `{$this->tableName}`.id AS id, date, alarm, active 
                FROM `{$this->tableName}` 
                INNER JOIN `smart-home_alarm-type` ON `{$this->tableName}`.idAlarm = `smart-home_alarm-type`.id
                WHERE active = 1 
                ORDER BY date DESC 
                LIMIT 1";
        
        $results = $this->queryRaw($sql);
        
        if (empty($results)) {
            return null;
        }
        
        $row = $results[0];
        return new AlarmRegister([
            'id' => (int)$row['id'],
            'date' => $row['date'],
            'alarm' => $row['alarm'],
            'active' => (bool)$row['active']
        ]);
    }
}
