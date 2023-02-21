<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request): Response
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return \response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): Response
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::guard('web')->logout();


        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return \response()->noContent();
    }
}
