<?php

namespace App\Services\Kisi\Resources;

use App\Services\Kisi\Api;

abstract class BaseResource
{
    /**
     * @param Api $param
     */
    public function __construct(
        protected readonly Api $api
    ) {
    }
}
