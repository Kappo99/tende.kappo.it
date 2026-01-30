<?php

namespace App\Managers;

use App\Common\BaseManager;
use App\Services\AlarmRegisterService;

class AlarmRegisterManager extends BaseManager
{
    public function __construct(AlarmRegisterService $service)
    {
        parent::__construct($service);
    }

    /**
     * Gestisce la logica di business per trovare i dati del registro allarmi
     */
    public function getByFilters(?string $date = null, ?int $limit = null): array
    {
        return $this->service->findByFilters($date, $limit);
    }

    /**
     * Gestisce l'inserimento di un nuovo allarme
     */
    public function insertAlarm(int $idAlarm): array
    {
        return $this->service->insertAlarm($idAlarm);
    }
}
