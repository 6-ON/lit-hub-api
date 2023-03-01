<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isValid = $request->validate([
            'content' => ['required', 'string', 'max:500'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ]);

        if ($isValid) {
            /* @var \stdClass $request */ //to remove error
            return Comment::create([
                'content' => $request->content,
                'post_id' => $request->post_id,
                'user_id' => $request->user()->id,
            ])->load('owner:id,username,image');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        abort_if($comment->owner()->isNot(\request()->user()), 403);
        $isValid = $request->validate([
            'content' => ['required', 'string', 'max:500'],
        ]);
        if ($isValid) {
            /* @var \stdClass $request */ //to remove error
            $comment->content = $request->content;
            return $comment;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): Response
    {
        abort_if($comment->owner()->isNot(\request()->user()), 403);
        $comment->delete();
        return \response()->noContent();

    }
}
