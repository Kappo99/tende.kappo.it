<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class RainSensorInsertRequestDto extends BaseDto
{
    public array $rain = [];
    public array $date = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        // Supporta sia array diretti che JSON decodificati
        if (isset($data['rain'])) {
            $this->rain = is_string($data['rain']) 
                ? json_decode($data['rain'], true) ?? [] 
                : (array)$data['rain'];
        }
        
        if (isset($data['date'])) {
            $this->date = is_string($data['date']) 
                ? json_decode($data['date'], true) ?? [] 
                : (array)$data['date'];
        }
    }

    public function isValid(): bool
    {
        return !empty($this->rain) 
            && !empty($this->date) 
            && count($this->rain) === count($this->date);
    }
}
