<?php

namespace App\Services\Kisi;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Api
{
    const BASE_URL = 'https://api.kisi.io/';
    protected PendingRequest $request;

    public function __construct(string $apiKey) {
        $this->request = Http::withHeaders([
            'Authorization' => 'KISI-LOGIN ' . $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }

    public function members(): Resources\Members {
        return new Resources\Members($this);
    }

    public function groupRoleAssignments(): Resources\GroupRoleAssignments {
        return new Resources\GroupRoleAssignments($this);
    }

    public function get(string $endpoint, array $data)
    {
        return $this->request->get(self::BASE_URL . $endpoint, $data);
    }

    public function post(string $endpoint, array $data)
    {
        return $this->request->post(self::BASE_URL . $endpoint, $data);
    }
}
