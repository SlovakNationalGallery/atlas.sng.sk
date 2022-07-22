<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/print', function (Request $request) {
    $codes = \App\Models\Code::all();
    return response()->view('print', compact('codes'));
});

Route::get('/img/{code}.svg', function (Request $request, $code) {
    $color = $request->get('color', 'white');
    return response()->view('code-svg', compact('code', 'color'))
        ->header('Content-Type', 'image/svg+xml')
        ->header('Cache-Control', 'max-age=15552000');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

