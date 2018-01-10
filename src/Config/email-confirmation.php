<?php

return [
    'requireEmailConfirmation' => true,
    'requireEmailIfNotPresent' => true,
    'statusMessages' => [
        'confirmed' => 'Your email address has been confirmed! You can now log in with your email address and password.',
        'alreadyConfirmed' => 'Your email address has already been confirmed. Please log in with your email address and password.',
        'pleaseConfirm' => 'You must confirm your email address before logging in. An email has been sent to {{ email }}. If you have not received the confirmation email, we can <a href="/confirm/{{ id }}/resend">resend it</a>.'
    ],
];
