<?php

namespace App\Dto\Request;

use App\Common\BaseDto;

class AlarmRegisterRequestDto extends BaseDto
{
    public ?string $date = null;
    public ?int $limit = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        
        $this->date = $data['date'] ?? null;
        $this->limit = isset($data['register-limit']) ? (int)$data['register-limit'] : null;
    }
}
