<?php

namespace App\Services\Kisi\Objects;

use Illuminate\Support\Arr;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly array $data = [],
    ) {}

    public static function make(array $data): self
    {
        return new self(
            id: Arr::pull($data, 'id'),
            name: Arr::pull($data, 'name'),
            email: Arr::pull($data, 'email'),
            data: $data
        );
    }

    public function __get(string $name)
    {
        switch($name) {
            case 'id': return $this->id;
            case 'name': return $this->name;
            case 'email': return $this->email;
            default: return $this->data[$name] ?? null;
        }
    }
}
