<?php

namespace App\Services\Kisi\Objects;

use Illuminate\Support\Arr;

class Member
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly array $data = [],
    ) {}

    public static function make(array $data): self
    {
        return new self(
            id: Arr::pull($data, 'id'),
            user: User::make(Arr::pull($data, 'user')),
            data: $data
        );
    }

    public function __get(string $name)
    {
        switch($name) {
            case 'id': return $this->id;
            case 'user': return $this->user->email;
            default: return $this->data[$name] ?? null;
        }
    }
}
