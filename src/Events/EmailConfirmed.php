<?php

namespace Submtd\EmailConfirmation\Events;

use Illuminate\Queue\SerializesModels;

class EmailConfirmed
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
