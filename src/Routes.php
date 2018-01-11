<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('confirm/{userId}/resend', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@resend');
    Route::get('confirm/{userId}/{confirmationToken}', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@confirm');
});
