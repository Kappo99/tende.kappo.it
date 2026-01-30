<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class ConsecutiveValuesRequestDto extends BaseDto
{
    public ?string $date = null;
    public ?int $consValue = null;
    public ?int $windMin = null;
    public ?int $windMax = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->date = $data['date'] ?? null;
        $this->consValue = isset($data['cons-value']) ? (int)$data['cons-value'] : null;
        $this->windMin = isset($data['wind-min']) ? (int)$data['wind-min'] : 150;
        $this->windMax = isset($data['wind-max']) ? (int)$data['wind-max'] : 1500;
    }
}
