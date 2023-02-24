<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MembershipController extends Controller
{


    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Group $group, Request $request)
    {
        //check if joined

        $joined = $group->memberships()->where('memberships.user_id',$request->user()->id)->exists();

        if ($joined) {
            return \response()->json(['message' => 'already Joined !'], 422);
        }

        $membership = new Membership();
        $membership->fill([
            'group_id' => $group->id,
            'user_id' => $request->user()->id,
        ]);
        $membership->save();
        return \response()->noContent();

    }


    /**
     * Remove the specified resource from storage.
     * @throws ValidationException
     */
    public function destroy(Group $group)
    {
        $joined = $group->memberships()->where('memberships.user_id',\request()->user()->id)->first() ?? false;
        abort_if(!$joined, 422);
        $joined->delete();
        return \response()->noContent();

    }
}
