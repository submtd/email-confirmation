@component('mail::message')
# Hello, {{ $user->name }}!

In order to complete your registration, you must confirm your email address by clicking the button below.

@component('mail::button', ['url' => url('confirm/' . $user->id . '/' . $user->confirmation_token)])
Confirm Email
@endcomponent

If you have can't see or click the button, please copy and paste the following URL in your web browser.

{{ url('confirm/' . $user->id . '/'. $user->confirmation_token) }}

Thanks,

{{ config('app.name') }}
@endcomponent
