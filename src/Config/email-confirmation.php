<?php

return [
    /**
     * set requireEmailConfirmation to true to enable, or false to disable email confirmations.
     */
    'requireEmailConfirmation' => true,

    /**
     * set redirectOnSuccess to the path the user shold be redirected to after successfully
     * confirming their email address.
     */
    'redirectOnSuccess' => '/',

    /**
     * set redirectOnFail to the path the user shold be redirected to after a failed attempt
     * at confirming their email address.
     */
    'redirectOnFail' => '/login',

    /**
     * set redirectOnResend to the path the user shold be redirected to after a requesting
     * a new confirmation email.
     */
    'redirectOnResend' => '/login',

    /**
     * set redirectOnAlreadyConfirmed to the path the user shold be redirected to after
     * trying to confirm a user that has already been confirmed.
     */
    'redirectOnAlreadyConfirmed' => '/',

    /**
     * The following status messages are flashed to the 'status' session variable
     * after various EmailConfirmation events.
     */
    'statusMessages' => [
        /**
         * confirm is the message flashed when a confirmation email is sent.
         */
        'confirm' => 'You must confirm your email address before logging in.',

        /**
         * invalidUserId is the message flashed when a user tries to confirm with
         * an invalid user id.
         */
        'invalidUserId' => 'Invalid user id.',

        /**
         * alreadyConfirmed is the message flashed when a user tries to confirm
         * a user that has already been confirmed.
         */
        'alreadyConfirmed' => 'Your email address has already been confirmed.',

        /**
         * invalidToken is flashed when a user tries to confirm with an invalid token.
         */
        'invalidToken' => 'Invalid confirmation token.',

        /**
         * confirmed is flashed after a user successfully confirms an email address.
         */
        'confirmed' => 'Your email address has been confirmed!',
    ],
];
