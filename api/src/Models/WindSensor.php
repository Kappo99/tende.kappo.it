<?php

namespace App\Models;

use App\Common\BaseModel;

class WindSensor extends BaseModel
{
    public ?int $id = null;
    public ?string $date = null;
    public ?int $frequency = null;
}
