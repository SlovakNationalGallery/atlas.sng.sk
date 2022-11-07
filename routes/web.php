<?php

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Section;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

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

Route::get('/items', function (Request $request) {
    $items = Item::with('code')->get();

    $responses = Http::pool(
        fn(Pool $pool) => $items->map(
            fn(Item $item) => $pool
                ->as($item->id)
                ->webumenia()
                ->get("/v2/items/{$item->id}")
        )
    );

    $collection = $items->map(
        fn(Item $item) => [
            'item' => $item,
            'webumenia_item' => $responses[$item->id]->object()?->data,
        ]
    );

    return response()->view('items', [
        'items' => ItemResource::collection($collection)->toArray($request),
    ]);
});

Route::get('/sections', function () {
    $sections = Section::with('code')->get();
    return response()->view('sections', compact('sections'));
});

Route::get('/img/{code}.svg', function (Request $request, $code) {
    $color = $request->get('color', 'white');
    return response()
        ->view('code-svg', compact('code', 'color'))
        ->header('Content-Type', 'image/svg+xml')
        ->header('Cache-Control', 'max-age=15552000');
})->where('code', '[0-1]{9}');

Route::get('/import', function () {
    Artisan::call('import:items');
    $output = Artisan::output();
    Artisan::call('import:sections');
    $output .= Artisan::output();
    return '<pre>' . $output . '</pre>';
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
