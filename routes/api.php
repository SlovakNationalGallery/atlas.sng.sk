<?php

use App\Http\Resources\BucketlistResource;
use App\Models\Code;
use App\Models\Item;
use App\Models\Place;
use App\Models\Story;
use App\Models\Section;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use App\Http\Resources\CodeResource;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\StoryResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\SectionResource;
use App\Models\Bucketlist;
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

Route::middleware(['cacheResponse'])->group(function () {

    /**
     * GET /api/verify/{code}
     *
     * Checks if the typed code is valid. If it is valid, the response will contain the code's data (related object type + ID)
     *
     * Otherwise, the request will fail with a 404.
     *
     * @urlParam code integer required Example: 17
     * 
     * @response status=404 scenario="Code not found" {"message": "Record not found."}
     */
    Route::get('/verify/{code}', function ($code) {
        return new CodeResource(Code::where('code', $code)->firstOrFail());
    });

    /**
     * GET api/items/{id}
     *
     * Gets the item with the given ID. If it is found, the response will contain the item's data.
     *
     * @urlParam id string required Example: SVK:SNG.O_1405
     */
    Route::get('/items/{id}', function (string $id) {
        $item = Item::find($id) ?: new Item();
        $response = Http::webumenia()->get("/v2/items/$id");

        if (!isset($response->object()->data)) {
            throw new NotFoundHttpException();
        }

        $data = $response->object()->data;
        return new ItemResource([
            'item' => $item,
            'webumenia_item' => $data,
        ]);
    });

    /**
     * GET api/sections/{id}s
     *
     * Gets the section for the given ID. If it is, the response will contain the section's data.
     *
     * @urlParam id string required Example: rec8or1MegfsJY2CO
     */
    Route::get('/sections/{id}', function (string $id) {
        $section = Section::findOrFail($id);

        $responses = Http::pool(
            fn (Pool $pool) => $section->items->map(
                fn (Item $item) => $pool
                    ->as($item->id)
                    ->webumenia()
                    ->get("/v2/items/{$item->id}")
            )
        );

        return new SectionResource([
            'section' => $section,
            'webumenia_items' => collect($responses)->map(fn (Response $response) => $response->object()->data),
        ]);
    });

    /**
     * GET api/stories/{id}
     *
     * Gets the story with the given ID. If it is, the response will contain the story's data.
     *
     * @urlParam id string required Example: rec2Cq3jSUmcpveKf
     */
    Route::get('/stories/{id}', function (string $id) {
        $story = Story::findOrFail($id);
        return new StoryResource($story);
    });

    /**
     * GET api/places/{id}
     *
     * Gets the place with the given ID. If it is, the response will contain the place's data.
     *
     * @urlParam id string required Example: SVK:SNG.O_1405
     */
    Route::get('/places/{id}', function (string $id) {
        $place = Place::findOrFail($id);
        return new PlaceResource($place);
    });

    /**
     * GET api/bucketlists/{id}
     *
     * Gets the items for the bucketlist/scavenger hunt. Returns the list of items and their data.
     *
     * @urlParam id string required Example: recUBMv1RNstZ2lLO
     */
    Route::get('/bucketlists/{id}', function (string $id) {
        $bucketlist = Bucketlist::findOrFail($id);

        $responses = Http::pool(
            fn (Pool $pool) => $bucketlist->items->map(
                fn (Item $item) => $pool
                    ->as($item->id)
                    ->webumenia()
                    ->get("/v2/items/{$item->id}")
            )
        );

        return new BucketlistResource([
            'bucketlist' => $bucketlist,
            'webumenia_items' => collect($responses)->map(fn (Response $response) => $response->object()->data),
        ]);
    });

    /**
     * GET api/related_items/{ids}
     *
     * Gets the data for the related items. Returns the list of items and their data.
     *
     * @urlParam ids comma separated string required Example: SVK:SNG.O_6833,SVK:SNG.O_2807
     */
    Route::get('/related_items/{ids}', function (string $ids) {
        $idArray = explode(',', $ids);
        $related_items = collect([]);
        foreach ($idArray as $item_id) {
            $response = Http::webumenia()->get("/v2/items/$item_id");
            $related_items[] = [
                'item' => new Item(),
                'webumenia_item' => $response->object()->data
            ];
        }
        return ItemResource::collection($related_items);
    });

});

/**
 * POST api/collections
 *
 * Saves the user collection. Returns the URL to the saved collection.
 * 
 * @bodyParam items string[] The list of item IDs. Example: ["SVK:SNG.IM_101","SVK:SNG.IM_304"]
 */
Route::post('/collections', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'items' => ['required', 'array'],
        'items.*' => ['required', 'exists:items,id', 'distinct'],
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

/**
 * GET api/collections/{hashid}
 *
 * Gets the saved user collection by hashid. Returns the array of item IDs.
 *
 * @urlParam hashid string required Example: n2m
 */
Route::get('/collections/{hashid}', function ($hashid) {
    $collection = Collection::findByHashidOrFail($hashid);
    return $collection->items;
});
