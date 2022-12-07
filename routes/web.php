<?php

use App\Models\Item;
use App\Models\Story;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Jobs\ImportStoriesJob;
use App\Jobs\ImportAuthoritiesJob;
use App\Jobs\ImportExhibitionsJob;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
    $items = Item::with('code', 'code.exhibition')
        ->get()
        ->sortBy(function ($item) {
            return $item->code->exhibition_id;
        });
    return response()->view('items', compact('items'));
});

Route::get('/sections', function () {
    $sections = Section::with('code', 'code.exhibition')
        ->get()
        ->sortBy(function ($section) {
            return $section->code->exhibition_id;
        });
    return response()->view('sections', compact('sections'));
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
    $output = "Import Exhibitions \n";
    ImportExhibitionsJob::dispatchSync();
    Artisan::call('import:items');
    $output .= "Import Items \n";
    $output .= Artisan::output();
    Artisan::call('import:sections');
    $output .= "Import Sections \n";
    $output .= Artisan::output();
    $output .= "Import Authorities \n";
    ImportAuthoritiesJob::dispatchSync();
    $output .= "Import Stories \n";
    ImportStoriesJob::dispatchSync();
    $output .= 'Done 🎉';
    return '<pre>' . $output . '</pre>';
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
