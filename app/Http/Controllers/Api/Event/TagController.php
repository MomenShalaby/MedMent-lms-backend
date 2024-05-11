<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Traits\CanLoadRelationships;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::query()->paginate();
        return $this->success($tags, "data is here", 200, true);
    }
    public function all()
    {
        $tags = Tag::all();
        return $this->success($tags, "data is here", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create(
            $request->all()
        );
        return $this->success($tag, "data inserted", 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return $this->success($tag, "data is here", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update(
            $request->all()
        );
        return $this->success($tag, "data updated", 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response(status: 204);
    }



    public function userIndex()
    {
        $user = Auth::user();
        $userTags = $user->tags()->paginate();
        return $this->success($userTags, "data is here", 200, true);
    }


    public function userUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tag.*' => 'exists:tags,id',
        ]);


        $user->tags()->sync((array) $request->input('tag'));
        $updatedTags = $user->tags()->get();
        return $this->success($updatedTags, "data updated", 202);

    }
}
