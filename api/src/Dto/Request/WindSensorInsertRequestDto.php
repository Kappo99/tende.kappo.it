<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class WindSensorInsertRequestDto extends BaseDto
{
    public array $frequency = [];
    public array $date = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        // Supporta sia array diretti che JSON decodificati
        if (isset($data['frequency'])) {
            $this->frequency = is_string($data['frequency']) 
                ? json_decode($data['frequency'], true) ?? [] 
                : (array)$data['frequency'];
        }
        
        if (isset($data['date'])) {
            $this->date = is_string($data['date']) 
                ? json_decode($data['date'], true) ?? [] 
                : (array)$data['date'];
        }
    }

    public function isValid(): bool
    {
        return !empty($this->frequency) 
            && !empty($this->date) 
            && count($this->frequency) === count($this->date);
    }
}
