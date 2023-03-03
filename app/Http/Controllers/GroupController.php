<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Group::latest()->get()->load('owner:id,username')->loadCount('members');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isValid = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:500'],
            'image' => ['required', 'url'],
        ]);

        if ($isValid) {
            return Group::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
                'user_id' => \request()->user()->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group,Request $request)
    {
        $joined = $group->memberships()->where('memberships.user_id',$request->user()->id)->exists();
        abort_if(!$joined,403,'You cant access to the group');
        return $group->load(['members:id,username,image', 'owner:id,username,image','messages'])->loadCount('members');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        abort_if($group->owner()->isNot(\request()->user()), 403);
        $isValid = $request->validate([
            'title' => ['sometimes', 'string', 'max:50'],
            'description' => ['sometimes', 'string', 'max:500'],
            'image' => ['sometimes', 'url'],
        ]);

        if ($isValid) {
            $group->fill($request->all());
            $group->save();
            return $group;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        abort_if($group->owner()->isNot(\request()->user()), 403);
        $group->delete();
        return \response()->noContent();

    }
}
