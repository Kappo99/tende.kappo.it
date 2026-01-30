<?php

namespace App\Models;

use App\Common\BaseModel;

class AlarmRegister extends BaseModel
{
    public ?int $id = null;
    public ?string $date = null;
    public ?int $idAlarm = null;
    public ?string $alarm = null;
    public ?bool $active = null;
}
