<?php

namespace App\Services\Kisi\Exceptions;

class MemberNotFoundException extends \Exception
{
    public function __construct($email)
    {
        parent::__construct("Member not found for email: $email");
    }
}
