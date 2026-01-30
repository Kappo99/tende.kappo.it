<?php

namespace App\Dto\Response;

use App\Common\BaseDto;
use App\Models\WindSensor;

class WindSensorResponseDto extends BaseDto
{
    public int $id;
    public string $date;
    public int $frequency;

    public function __construct(WindSensor $model)
    {
        parent::__construct([
            'id' => $model->id,
            'date' => $model->date,
            'frequency' => $model->frequency,
        ]);
        
        $this->id = $model->id;
        $this->date = $model->date;
        $this->frequency = $model->frequency;
    }

    public static function fromArray(array $models): array
    {
        return array_map(function (WindSensor $model) {
            return new self($model);
        }, $models);
    }
}
