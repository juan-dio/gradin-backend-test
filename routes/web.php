<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Backend Service',
        'status' => 'active',
    ]);
});
