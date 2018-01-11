<?php

namespace Submtd\EmailConfirmation\Events;

use Illuminate\Queue\SerializesModels;

/**
 * The EmailConfirmed event is created whenever a user
 * successfully confirms their email address.
 */
class EmailConfirmed
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
