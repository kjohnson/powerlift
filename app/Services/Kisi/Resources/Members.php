<?php

namespace App\Services\Kisi\Resources;

use App\Services\Kisi\Exceptions\MemberNotCreatedException;
use App\Services\Kisi\Exceptions\MemberNotFoundException;
use App\Services\Kisi\Objects\Member;
use Illuminate\Http\Client\RequestException;

class Members extends BaseResource
{
    protected function get(array $data)
    {
        return collect($this->api->get('members', $data)->json())->map(function ($member) {
            return Member::make($member);
        });
    }

    /**
     * @throws MemberNotFoundException
     */
    public function getByEmail(string $email)
    {
        return $this->get([
            'query' => $email,
            'limit' => 1,
        ])->first() ?? throw new MemberNotFoundException($email);
    }

    /**
     * @throws MemberNotCreatedException
     */
    public function create(string $name, string $email, array $data = [])
    {
        try {
            return Member::make($this->api->post('members', [
                'member' => [
                    'name' => $name,
                    'email' => $email,
                    ...$data
                ]
            ])->throw()->json());
        } catch (RequestException $e) {
            throw new MemberNotCreatedException($e->response->json());
        }
    }
}
