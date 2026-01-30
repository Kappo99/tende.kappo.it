<?php

namespace App\Dto\Response;

use App\Common\BaseDto;
use App\Models\RainSensor;

class RainSensorResponseDto extends BaseDto
{
    public int $id;
    public string $date;
    public bool $rain;

    public function __construct(RainSensor $model)
    {
        parent::__construct([
            'id' => $model->id,
            'date' => $model->date,
            'rain' => (bool)$model->rain,
        ]);
        
        $this->id = $model->id;
        $this->date = $model->date;
        $this->rain = (bool)$model->rain;
    }

    public static function fromArray(array $models): array
    {
        return array_map(function (RainSensor $model) {
            return new self($model);
        }, $models);
    }
}
