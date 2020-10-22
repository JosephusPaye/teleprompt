<?php

use App\Models\Presentation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('app', [
        'backendData' => [
            'view' => 'start',
            'csrfToken' => csrf_token(),
        ]
    ]);
});

Route::get('/new', function () {
    $code = strtoupper(Str::random(8));

    while (Presentation::where('code', $code)->exists()) {
        $code = strtoupper(Str::random(8));
    }

    $presentation = Presentation::create([
        'title' => 'Untitled Presentation',
        'code' => $code,
        'content' => '',
    ]);

    return redirect('/' . $presentation->code);
});

Route::get('/{code}', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    return view('app', [
        'backendData' => [
            'view' => 'presentation',
            'code' => $code,
            'presentation' => $presentation ? $presentation->toArray() : null,
            'csrfToken' => csrf_token(),
        ]
    ]);
});

Route::patch('/{code}', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    if (!$presentation) {
        return response()
            ->json([
                'status' => 'NOT_FOUND',
                'error' => 'Presentation not found'
            ], 404);
    }

    $validatedData = request()->validate([
        'title' => 'required|string',
        'content' => 'string',
    ]);

    $presentation->title = $validatedData['title'];
    $presentation->content = $validatedData['content'];
    $presentation->save();

    return response()->json([
        'status' => 'OK',
        'presentation' => $presentation,
    ], 200);
});

Route::delete('/{code}', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    if (!$presentation) {
        return response()
            ->json([
                'status' => 'NOT_FOUND',
                'error' => 'Presentation not found'
            ], 404);
    }

    $presentation->delete();

    return response()->json([
        'status' => 'OK',
        'redirect_to' => '/',
    ], 200);
});

Route::patch('/{code}/settings', function ($code) {
    $presentation = Presentation::where('code', $code)->first();

    if (!$presentation) {
        return response()
            ->json([
                'status' => 'NOT_FOUND',
                'error' => 'Presentation not found'
            ], 404);
    }

    $validatedData = request()->validate([
        'settings' => 'required|array',
    ]);

    $presentation->settings = $validatedData['settings'];
    $presentation->save();

    return response()->json([
        'status' => 'OK',
        'presentation' => $presentation,
    ], 200);
});

