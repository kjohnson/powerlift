<?php

namespace App\Services\Kisi\Resources;

use App\Services\Kisi\Api;
use App\Services\Kisi\Exceptions\GroupRoleAssignmentNotCreatedException;
use App\Services\Kisi\Exceptions\MemberNotCreatedException;
use App\Services\Kisi\Exceptions\MemberNotFoundException;
use App\Services\Kisi\Objects\Member;
use App\Services\Kisi\Objects\User;
use Illuminate\Http\Client\RequestException;

class GroupRoleAssignments extends BaseResource
{
    /**
     * @throws GroupRoleAssignmentNotCreatedException
     */
    public function create(User $user, string $roleId, int $groupId)
    {
        try {
            return $this->api->post('role_assignments', [
                'role_assignment' => [
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'group_id' => $groupId,
                ]
            ])->throw()->json();
        } catch (RequestException $e) {
            throw new GroupRoleAssignmentNotCreatedException($e->response->json());
        }
    }

    /**
     * @throws GroupRoleAssignmentNotCreatedException
     */
    public function createForMember(Member $member)
    {
        return $this->create(
            user: $member->user,
            roleId: config('services.kisi.default_role_id'),
            groupId: config('services.kisi.default_group_id')
        );
    }
}
