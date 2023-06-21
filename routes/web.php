<?php

use App\Models\Item;
use App\Models\Place;
use App\Models\Story;
use App\Jobs\ImportJob;
use App\Models\Section;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    $exhibition = null;
    $query = Item::with('code', 'code.exhibition');
    if ($request->has('exhibition_id')) {
        $exhibition = Exhibition::findOrFail($request->get('exhibition_id'));
        $query->whereHas('code.exhibition', function ($query) use ($request) {
            $query->where('id', $request->get('exhibition_id'));
        });
    }
    $items = $query->get()
        ->sortBy(function ($item) {
            return $item->code?->exhibition_id;
        });
    return response()->view('items', compact('items', 'exhibition'));
});

Route::get('/sections', function () {
    $sections = Section::with('code', 'code.exhibition')
        ->get()
        ->sortBy(function ($section) {
            return $section->code->exhibition_id;
        });
    return response()->view('sections', compact('sections'));
});

Route::get('/places', function () {
    $places = Place::with('code', 'code.exhibition')
        ->get()
        ->sortBy(function ($section) {
            return $section->code->exhibition_id;
        });
    return response()->view('places', compact('places'));
});

Route::get('/exhibitions', function () {
    $exhibitions = Exhibition::withCount('codes')->get();
    return response()->view('exhibitions', compact('exhibitions'));
});

Route::get('/stories', function () {
    $stories = Story::with('links')->get();
    return response()->view('stories', compact('stories'));
});

Route::get('/img/{code}.svg', function (Request $request, $code) {
    $color = $request->get('color', 'white');
    return response()
        ->view('code-svg', compact('code', 'color'))
        ->header('Content-Type', 'image/svg+xml')
        ->header('Cache-Control', 'max-age=15552000');
})->where('code', '[0-1]{9}');

Route::get('/import', function () {
    return view('import');
});

Route::get('/import/{type}', function (string $type) {
    ImportJob::dispatch($type);
    return response(sprintf('Queued at %s', now()->toDateTimeString()));
})->name('import_type');

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
