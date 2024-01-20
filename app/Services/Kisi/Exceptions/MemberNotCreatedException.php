<?php

namespace App\Services\Kisi\Exceptions;

class MemberNotCreatedException extends \Exception
{
    public function __construct($payload)
    {
        parent::__construct('Unable to create member: ' . $payload['message'] ?? json_encode($payload, JSON_PRETTY_PRINT) );
    }
}
