<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;
use Submtd\EmailConfirmation\Events\EmailConfirmed;
use Submtd\EmailConfirmation\Events\FailedEmailConfirmation;
use Illuminate\Support\Facades\Request;

/**
 * The ConfirmationController class handles the confirm/{userId}/{confirmationToken}
 * and confirm/{userId}/resend routes
 */
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
     * Class constructor. Grabs some values from config files and populates
     * the class properties.
     */
    public function __construct()
    {
        $this->userClass = config('auth.providers.users.model');
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
        try {
            // attempt to load the user via the userId
            if (!$user = $this->userClass::find($userId)) {
                // user wasn't found
                abort(404, 'User not found.');
            }
            // check if the user is already confirmed
            if ($user->confirmed) {
                // user was already confirmed
                abort(400, 'User has already been confirmed.');
            }
            // compare the confirmation token with the token in the user object
            if ($user->confirmation_token != $confirmationToken) {
                // token doesn't match!
                event(new FailedEmailConfirmation($user));
                abort(403, 'Invalid confirmation token.');
            }
            // everything looks good! let's update the user object
            $user->confirmation_token = null;
            $user->confirmed = true;
            $user->save();
            // create an email confirmed event
            event(new EmailConfirmed($user));
            // log the user in, flash a message and redirect
            Auth::loginUsingId($user->id);
            Request::session()->flash('status', 'Your email address has been confirmed!');
            return redirect()->intended('login');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
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
        try {
            // attempt to load the user via the userId
            if (!$user = $this->userClass::find($userId)) {
                // user wasn't found
                abort(404, 'User not found.');
            }
            // check if the user is already confirmed
            if ($user->confirmed) {
                // user was already confirmed
                abort(400, 'User has already been confirmed.');
            }
            // check to see if the user has a confirmation token
            if (!$user->confirmation_token) {
                // no token found... let's create one
                $user->confirmation_token = str_random(32);
                $user->save();
            }
            // send the confirmation email, flash a message and redirect
            Mail::to($user)->queue(new ConfirmEmail($user));
            Request::session()->flash('status', 'You must confirm your email address before logging in.');
            return redirect()->intended('login');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
