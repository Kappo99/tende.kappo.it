<?php

namespace App\Models;

use App\Common\BaseModel;

class RainSensor extends BaseModel
{
    public ?int $id = null;
    public ?string $date = null;
    public ?bool $rain = null;
}
