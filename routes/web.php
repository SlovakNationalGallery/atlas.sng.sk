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

Route::get('/img/{code}.svg', function (Request $request, $code) {
    // @todo: in bin or decimal?
    $color = $request->get('color', 'white');
    return response()->view('code-svg', compact('code', 'color'))->header('Content-Type', 'image/svg+xml');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

