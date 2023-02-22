<?php /** @noinspection ALL */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \request([]);
        return Post::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isValid=  $request->validate([
            'title'=>'required|max:50',
            'description'=>'required|max:500',
            'category_id'=>'required',
            'image'=>'required|url',
            'attachment'=>'required|url',
        ]);
        if($isValid){
            return Post::create([
                'title'=>$request->title,
                'user_id'=> $request->user()->id,
                'description'=>$request->description,
                'category_id'=>$request->category_id,
                'image'=>$request->image,
                'attachment'=>$request->attachment,
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return \response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $isValid=  $request->validate([
            'title'=>'sometimes|max:50',
            'description'=>'sometimes|max:500',
            'image'=>'sometimes|url',
            'attachment'=>'sometimes|url',
        ]);
        if($isValid){
            $post->fill($request->all());
            $post->save();
            return $post;
        }
        return \response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        $post->delete();
        return \response()->noContent();
    }
}
