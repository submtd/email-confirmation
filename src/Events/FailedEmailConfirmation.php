<?php

namespace Submtd\EmailConfirmation\Events;

use Illuminate\Queue\SerializesModels;

/**
 * The FailedEmailConfirmation event is sent when an email
 * confirmation attempt fails.
 */
class FailedEmailConfirmation
{
    use SerializesModels;

    /**
     * The user object
     *
     * @var object
     */
    public $user;

    /**
     * Class constructor
     *
     * @param object $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
