<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class WindSensorRequestDto extends BaseDto
{
    public ?string $date = null;
    public ?int $minValue = null;
    public ?int $limit = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->date = $data['date'] ?? null;
        $this->minValue = isset($data['min-value']) ? (int)$data['min-value'] : null;
        $this->limit = isset($data['wind-limit']) ? (int)$data['wind-limit'] : null;
    }
}
