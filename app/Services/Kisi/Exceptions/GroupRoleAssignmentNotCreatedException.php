<?php

namespace App\Services\Kisi\Exceptions;

class GroupRoleAssignmentNotCreatedException extends \Exception
{
    public function
    __construct($payload)
    {
        parent::__construct('Unable to create group role assignment: ' . isset($payload['message']) ? $payload['message'] : json_encode($payload, JSON_PRETTY_PRINT) );
    }
}
