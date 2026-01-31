<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class ConsecutiveValuesRequestDto extends BaseDto
{
    public ?string $date = null;
    public ?int $consValue = null;
    public ?int $min = null;
    public ?int $max = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->date = $data['date'] ?? null;
        $this->consValue = isset($data['consValue']) ? (int)$data['consValue'] : null;
        $this->min = isset($data['min']) ? (int)$data['min'] : 150;
        $this->max = isset($data['max']) ? (int)$data['max'] : 1500;
    }
}
