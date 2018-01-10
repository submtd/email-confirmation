@component('mail::message')
# Introduction

{{ $user->name }}

@component('mail::button', ['url' => url('confirm/' . $user->id . '/' . $user->confirmation_token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
