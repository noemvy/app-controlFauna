<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clima', function () {
    $apiKey = config('services.openweathermap.key');

    $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
        'q' => 'Mexico',           // Puedes cambiarlo por cualquier ciudad
        'appid' => $apiKey,
        'units' => 'metric',
        'lang' => 'es',
    ]);

    return $response->json();
});
// Route::get('/clima', function () {
//     $apiKey = config('services.openweathermap.key');

//     return 'Tu API key es: ' . $apiKey;
// });

