<?php

/**
 * EmailConfirmation routes
 */
Route::group(['middleware' => ['web']], function () {
    // resend a confirmation email
    Route::get('confirm/{userId}/resend', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@resend');
    // verify an email
    Route::get('confirm/{userId}/{confirmationToken}', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@confirm');
});
