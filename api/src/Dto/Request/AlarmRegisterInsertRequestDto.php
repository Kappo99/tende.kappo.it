<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class AlarmRegisterInsertRequestDto extends BaseDto
{
    public int $idAlarm;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->idAlarm = isset($data['idAlarm']) ? (int)$data['idAlarm'] : 0;
    }

    public function isValid(): bool
    {
        return $this->idAlarm >= 0;
    }
}
