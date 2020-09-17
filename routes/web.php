<?php

use App\Models\Presentation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app', [
        'backendData' => [
            'view' => 'start',
        ]
    ]);
});

Route::get('/{code}', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    if ($presentation) {
        $presentation->load('slides');
    }

    return view('app', [
        'backendData' => [
            'view' => 'open',
            'presentation' => $presentation,
        ]
    ]);
});
