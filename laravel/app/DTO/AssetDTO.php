<?php

namespace App\DTO;

class AssetDTO
{
    public const NAME = 'name';

    public $name;

    public function __construct(array $payload)
    {
        $this->name = $payload[self::NAME];
    }

    public function toArray()
    {
        return [
            self::NAME => $this->name
        ];
    }
}
