<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('confirm/{id}/resend', '\Submtd\EmailConfirmation\Controllers\Confirmation@resend');
    Route::get('confirm/{id}/{token}', '\Submtd\EmailConfirmation\Controllers\Confirmation@confirm');
});
