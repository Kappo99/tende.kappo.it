<?php

namespace App\Models;

use App\Common\BaseModel;

class AlarmType extends BaseModel
{
    public ?int $id = null;
    public ?string $alarm = null;
    public ?bool $active = null;
}
