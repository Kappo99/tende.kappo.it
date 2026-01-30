<?php

namespace App\Services;

use App\Common\BaseService;
use App\Repositories\AlarmRegisterRepository;

class AlarmRegisterService extends BaseService
{
    public function __construct(AlarmRegisterRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Trova i dati del registro allarmi con filtri
     */
    public function findByFilters(?string $date = null, ?int $limit = null): array
    {
        return $this->repository->findByFilters($date, $limit);
    }

    /**
     * Inserisce un nuovo allarme con logica di business
     */
    public function insertAlarm(int $idAlarm): array
    {
        $config = require __DIR__ . '/../../config/app.php';
        $minuti = $config['minuti'];
        
        date_default_timezone_set("Europe/Rome");
        $date = date("Y-m-d H:i:s");
        
        // Ottieni l'ultimo allarme attivo
        $lastAlarm = $this->repository->getLastActiveAlarm();
        
        $minutes = $minuti; // Default
        if ($lastAlarm !== null) {
            $from_time = strtotime($lastAlarm->date);
            $to_time = strtotime($date);
            $minutes = (int)round(abs($to_time - $from_time) / 60);
        }
        
        // Determina se l'allarme è attivo (se sono passati almeno MINUTI dall'ultimo)
        $active = $minutes >= $minuti;
        
        // Inserisci l'allarme
        $result = $this->repository->insertAlarm($idAlarm, $date, $active);
        
        return [
            'success' => $result,
            'date' => $date,
            'minutes' => $minutes,
            'active' => $active,
            'shouldNotify' => $active
        ];
    }
}
