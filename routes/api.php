<?php

use App\Http\Resources\CodeResource;
use App\Http\Resources\ItemResource;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/verify/{code}', function ($code) {
    return new CodeResource(Code::where('code', $code)->firstOrFail());
});

Route::get('/items/{id}', function ($id) {
    $description = Code::where('item_id', $id)->firstOrFail()->description;

    $response = Http::get(config('services.webumenia.api') . '/items/' . $id, [
        'locale' =>  app()->getLocale()
    ]);
    $item = $response->object()->document->content;
    if (!empty($description)) {
        $item->description = $description;
    }
    return new ItemResource($item);
});
