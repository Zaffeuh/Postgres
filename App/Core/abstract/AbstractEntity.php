<?php

namespace App\Core\Abstract;

abstract class AbstractEntity
{

    abstract public static function toObject(array $data): static;
    abstract public function toArray(object $data): array;

    public static function toJson(object $data): string
    {
        $instance = new static();
        return json_encode($instance->toArray($data), JSON_PRETTY_PRINT);
    }

}
