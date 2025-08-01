<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreTagRequest;
use App\Http\Requests\Api\V1\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Tag::class);

        $perPage = $request->query('per_page', 10);

        return TagResource::collection(Tag::paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $this->authorize('create', Tag::class);

        return new TagResource(Tag::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $tag->update($request->validated());

        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return response()->json();
    }
}
