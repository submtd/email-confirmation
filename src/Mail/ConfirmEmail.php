<?php

namespace Submtd\EmailConfirmation\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * The ConfirmEmail class sends an email to the user when
 * email confirmation is needed.
 */
class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;

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

    /**
     * The build method returns the email that should be sent to the user.
     *
     * @return void
     */
    public function build()
    {
        return $this->markdown('email-confirmation::ConfirmEmail');
    }
}
