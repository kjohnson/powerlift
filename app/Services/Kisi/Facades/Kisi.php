<?php

namespace App\Services\Kisi\Facades;

use App\Services\Kisi\Resources\Members;
use App\Services\Kisi\Resources\GroupRoleAssignments;

/**
 * @method static Members members()
 * @method static GroupRoleAssignments groupRoleAssignments()
 */
class Kisi extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'kisi';
    }
}
