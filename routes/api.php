<?php

use App\Models\Code;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Resources\CodeResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\SectionResource;
use App\Models\Item;
use App\Models\Section;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

Route::get('/items/{id}', function (string $id) {
    $item = Item::firstWhere('webumenia_id', $id) ?: new Item();
    $response = Http::webumenia()->get("/v2/items/$id");

    if (!isset($response->object()->data)) {
        throw new NotFoundHttpException();
    }

    $data = $response->object()->data;
    $data->item = $item;
    return new ItemResource($data);
});

Route::get('/section/{id}', function (string $id) {
    $section = Section::findOrFail($id);
    return new SectionResource($section);
});

Route::post('/collections', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'items' => 'required|array|distinct',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'error_message' => $validator->errors()->first()], 422);
    }

    $collection = Collection::create($validator->validated());
    return response()->json([
        'success' => true,
        'url' => url('/', $collection->hashid()),
    ]);
});

Route::get('/collections/{hashid}', function ($hashid) {
    $collection = Collection::findByHashidOrFail($hashid);
    return $collection->items;
});
