<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use App\Models\House;
use App\Models\Review;
use App\Models\SittingRequest;


class AdminController extends Controller
{
    public function index()
    {
        $users = User::all()->except(auth()->user()->id);
        $sittingRequests = SittingRequest::all();

        return view('admin.index', compact('users', 'sittingRequests'));
    }

    public function blockUser(User $user)
    {
        $user->blocked = true;
        $user->save();
        return redirect()->route('admin.index')->with('success', 'User has been blocked');
    }

    public function unblockUser(User $user)
    {
        $user->blocked = false;
        $user->save();
        return redirect()->route('admin.index')->with('success', 'User has been unblocked');
    }

    public function deleteRequest(SittingRequest $sittingRequest)
    {
        $sittingRequest->delete();
        return redirect()->route('admin.index')->with('success', 'Request has been deleted');
    }

}
