<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('confirm/{id}/resend', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@resend');
    Route::get('confirm/{id}/{token}', '\Submtd\EmailConfirmation\Controllers\ConfirmationController@confirm');
});
