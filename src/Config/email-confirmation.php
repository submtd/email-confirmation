<?php

return [
    'requireEmailConfirmation' => true,
    'redirectOnSuccess' => '/',
    'redirectOnFail' => '/login',
    'redirectOnResend' => '/login',
    'redirectOnAlreadyConfirmed' => '/',
    'statusMessages' => [
        'confirm' => 'You must confirm your email address before logging in.',
        'invalidUserId' => 'Invalid user id.',
        'alreadyConfirmed' => 'Your email address has already been confirmed.',
        'invalidToken' => 'Invalid confirmation token.',
        'confirmed' => 'Your email address has been confirmed!',
    ],
];
