<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email']));
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect()->route('login')->with('success', 'User deleted successfully.');
    }
}
