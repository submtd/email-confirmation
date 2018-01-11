<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;
use Submtd\EmailConfirmation\Events\EmailConfirmed;
use Submtd\EmailConfirmation\Events\FailedEmailConfirmation;
use Illuminate\Support\Facades\Request;

class ConfirmationController extends Controller
{
    /**
     * The user class for your laravel application. Typically App\User()
     * This variable is populated from the value in config/auth.php
     *
     * @var string
     */
    protected $userClass;

    /**
     * The URL the user should be redirected to after confirming their
     * email address. This is populated from config/email-confirmation.php
     *
     * @var string
     */
    protected $redirectOnSuccess;

    /**
     * The URL the user should be redirected to after a failed confirmation
     * attempt. This is populated from config/email-confirmation.php
     *
     * @var string
     */
    protected $redirectOnFail;

    /**
     * The URL the user should be redirected to after requesting a new
     * confirmation email. This is populated from config/email-confirmation.php
     *
     * @var string
     */
    protected $redirectOnResend;

    /**
     * Class constructor. Grabs some values from config files and populates
     * the class properties.
     */
    public function __construct()
    {
        $this->userClass = config('auth.providers.users.model');
        $this->redirectOnSuccess = config('email-confirmation.redirectOnSuccess', '/');
        $this->redirectOnFail = config('email-confirmation.redirectOnFail', '/login');
        $this->redirectOnAlreadyConfirmed = config('email-confirmation.redirectOnAlreadyConfirmed', '/');
        $this->redirectOnResend = config('email-confirmation.redirectOnResend', '/login');
    }

    /**
     * Confirms an email address. This method is called when a user visits
     * /confirm/{userId}/{confirmationToken}
     *
     * @param int $userId
     * @param string $confirmationToken
     * @return void
     */
    public function confirm($userId, $confirmationToken)
    {
        // attempt to load the user via the userId
        if (!$user = $this->userClass::find($userId)) {
            // user wasn't found... flash a message and redirect
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidUserId', 'Invalid user id.'));
            return redirect($this->redirectOnFail);
        }
        // check if the user is already confirmed
        if ($user->confirmed) {
            // user was already confirmed... flash a message and redirect
            Request::session()->flash('status', config('email-confirmation.statusMessages.alreadyConfirmed', 'Your email has already been confirmed.'));
            return redirect($this->redirectOnAlreadyConfirmed);
        }
        // compare the confirmation token with the token in the user object
        if ($user->confirmation_token != $confirmationToken) {
            // token doesn't match! create an event, flash a message and redirect
            event(new FailedEmailConfirmation($user));
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidToken', 'Invalid confirmation token.'))->error();
            return redirect($this->redirectOnFail);
        }
        // everything looks good! let's update the user object
        $user->confirmation_token = null;
        $user->confirmed = true;
        $user->save();
        // create an email confirmed event
        event(new EmailConfirmed($user));
        // log the user in, flash a message and redirect
        Auth::loginUsingId($user->id);
        Request::session()->flash('status', config('email-confirmation.statusMessages.confirmed', 'Your email address has been confirmed!'))->success();
        return redirect($this->redirectOnSuccess);
    }

    /**
     * Resends the confirmation email. This method is called when a user visits
     * /confirm/{userId}/resend
     *
     * @param int $userId
     * @return void
     */
    public function resend($userId)
    {
        // attempt to load the user via the userId
        if (!$user = $this->userClass::find($userId)) {
            // user wasn't found... flash a message and redirect
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidUserId', 'Invalid user id.'))->warning();
            return redirect()->back();
        }
        // check if the user is already confirmed
        if ($user->confirmed) {
            // user was already confirmed... flash a message and redirect
            Request::session()->flash('status', config('email-confirmation.statusMessages.alreadyConfirmed', 'Your email address has already been confirmed.'))->warning();
            return redirect()->back();
        }
        // check to see if the user has a confirmation token
        if (!$user->confirmation_token) {
            // no token found... let's create one
            $user->confirmation_token = str_random(32);
            $user->save();
        }
        // send the confirmation email, flash a message and redirect
        Mail::to($user)->queue(new ConfirmEmail($user));
        Request::session()->flash('status', config('email-confirmation.statusMessages.confirm', 'You must confirm your email address before logging in.'));
        return redirect($this->redirectOnResend);
    }
}
