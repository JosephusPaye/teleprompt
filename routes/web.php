<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app', [
        'vue_data' => [
            'year' => date('Y'),
        ]
    ]);
});
