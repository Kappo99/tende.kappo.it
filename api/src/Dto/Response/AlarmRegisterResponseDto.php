<?php

namespace App\Dto\Response;

use App\Common\BaseDto;
use App\Models\AlarmRegister;

class AlarmRegisterResponseDto extends BaseDto
{
    public int $id;
    public string $date;
    public string $alarm;
    public bool $active;

    public function __construct(AlarmRegister $model)
    {
        parent::__construct([
            'id' => $model->id,
            'date' => $model->date,
            'alarm' => $model->alarm,
            'active' => (bool)$model->active,
        ]);
        
        $this->id = $model->id;
        $this->date = $model->date;
        $this->alarm = $model->alarm;
        $this->active = (bool)$model->active;
    }

    public static function fromArray(array $models): array
    {
        return array_map(function (AlarmRegister $model) {
            return new self($model);
        }, $models);
    }
}
