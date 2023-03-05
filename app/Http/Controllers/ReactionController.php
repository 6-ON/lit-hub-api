<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReactionController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, Request $request)
    {
        $reacted = $post->reactions()->where(['reactions.user_id' => $request->user()->id])->exists();

        if ($reacted) {
            return \response()->json(['message' => 'already reacted !'], 422);
        }
        $request->validate([
            'emoji' => 'required|string|max:2'
        ]);
        $reaction = new  Reaction();
        $reaction->fill([
            'post_id' => $post->id,
            'emoji' => $request->emoji,
            'user_id' => $request->user()->id,
        ]);
        $reaction->save();
        return \response(status: 201);
    }
    public function update(Post $post, Request $request)
    {
        $request->validate([
            'emoji' => 'required|string|max:2'
        ]);
        $reaction = $post->reactions()->where(['reactions.user_id' => $request->user()->id])->first() ?? false;
        if ($reaction) {
            $reaction->emoji = $request->emoji;
            $reaction->save();
            return  \response(status: 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $reacted = $post->reactions()->where('reactions.user_id', \request()->user()->id)->first() ?? false;
        abort_if(!$reacted, 422);
        $reacted->delete();
        return \response()->noContent();
    }
}
