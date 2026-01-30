<?php

namespace App\Common;

abstract class BaseModel
{
    protected array $attributes = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
            $this->attributes[$key] = $value;
        }
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }
}
