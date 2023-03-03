<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $isValid = $request->validate([
            'content' => ['required', 'string', 'max:500'],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
        ]);

        // check if user joined
        DB::listen(function ($query){
            logger($query->sql);
        });
        /* @var Group $group */
        $group = Group::find($request->group_id);
        $joined = $group->members()->where('users.id', $request->user()->id)->exists();
        abort_if(!$joined,403);

        if ($isValid) {
            /* @var \stdClass $request */ //to remove error
            return Message::create([
                'content' => $request->content,
                'group_id' => $request->group_id,
                'user_id' => $request->user()->id,
            ])->load('user:id,username,image');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
//        check if user joined
        abort_if($message->owner()->isNot(\request()->user()), 403);
        $isValid = $request->validate([
            'content' => ['required', 'string', 'max:500'],
        ]);
        if ($isValid) {
            /* @var \stdClass $request */ //to remove error
            $message->content = $request->content;
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        abort_if($message->owner()->isNot(\request()->user()), 403);
        $message->delete();
        return \response()->noContent();
    }
}
