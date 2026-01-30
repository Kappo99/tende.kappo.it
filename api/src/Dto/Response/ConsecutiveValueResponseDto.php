<?php

namespace App\Dto\Response;

use App\Common\BaseDto;

class ConsecutiveValueResponseDto extends BaseDto
{
    public int $id;
    public string $date;

    public function __construct(int $id, string $date)
    {
        parent::__construct([
            'id' => $id,
            'date' => $date,
        ]);
        
        $this->id = $id;
        $this->date = $date;
    }

    public static function fromArray(array $data): array
    {
        return array_map(function ($item) {
            return new self($item['id'], $item['date']);
        }, $data);
    }
}
