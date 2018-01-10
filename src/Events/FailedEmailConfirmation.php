<?php

namespace Submtd\EmailConfirmation\Events;

use Illuminate\Queue\SerializesModels;

class FailedEmailConfirmation
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
