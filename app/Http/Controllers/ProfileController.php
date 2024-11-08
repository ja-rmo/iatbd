<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;



use App\Models\Profile;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
        return view('user.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('user.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function profileEdit(Request $request): View
    {
        $profile = $request->user()->profile;
        return view('profile.show', compact('profile'));
    }

    public function profileUpdate(Request $request, Profile $profile): RedirectResponse
    {
        //log the profile userid and auth::id
        if ($profile->user_id != Auth::id()) {
            return Redirect::route('dashboard')->with('error', 'You are not authorized to edit this profile.');
        }

        $request->validate([
            'role' => 'sometimes|in:sitter,owner',
            'bio' => 'sometimes|string|max:1000'
        ]);

        $profile->update($request->all()); // Update de bio
        $profile->save(); // Sla het profiel op

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.'); // Redirect naar de edit page met een succesmelding
    }

    public function photoUpdate(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = $request->user()->profile;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');

            $profile->photo = $path;
            $profile->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
