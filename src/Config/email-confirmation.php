<?php

return [
    'requireEmailConfirmation' => true,
    'redirectOnSuccess' => '/',
    'redirectOnFail' => '/login',
    'redirectOnResend' => '/login',
    'redirectOnAlreadyConfirmed' => '/',
    'statusMessages' => [
        'confirm' => 'You must confirm your email address before logging in. An email has been sent to {{ $user->email }}. If you have not received the confirmation email, we can <a href="{{ url(\'/confirm/\' . $user->id . \'/resend\') }}">resend it</a>.',
        'invalidUserId' => 'Invalid user id.',
        'alreadyConfirmed' => 'Your email address has already been confirmed.',
        'invalidToken' => 'Invalid confirmation token.',
        'confirmed' => 'Your email address has been confirmed!',
    ],
];
