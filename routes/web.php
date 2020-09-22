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
            'view' => 'presentation',
            'presentation' => $presentation,
        ]
    ]);
});

Route::post('/{code}/settings', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    if (!$presentation) {
        return response()
            ->json([
                'status' => 'NOT_FOUND',
                'error' => 'Presentation not found'
            ], 404);
    }

    $presentation->settings = request()->input('settings');
    $presentation->save();

    $presentation->load('slides');

    return response()->json([
        'status' => 'OK',
        'presentation' => $presentation,
    ], 200);
});
