<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->favourites()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        
        request()->user()->favourites()->attach($post);
        return response(status:Response::HTTP_CREATED);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        Auth::user()->favourites()->detach($post);
        return response()->noContent();
    }
}
