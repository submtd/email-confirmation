<?php

return [
    'requireEmailConfirmation' => true,
    'redirectOnSuccess' => '/',
    'redirectOnFail' => '/login',
    'redirectOnResend' => '/login',
    'redirectOnAlreadyConfirmed' => '/',
    'statusMessages' => [
        'invalidUserId' => 'Invalid user id.',
        'alreadyConfirmed' => 'Your email address has already been confirmed.',
        'invalidToken' => 'Invalid confirmation token.',
        'confirmed' => 'Your email address has been confirmed!',
    ],
];
