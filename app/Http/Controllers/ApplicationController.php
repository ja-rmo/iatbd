<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->profile->role === 'owner'){
            return view('applications.index', compact('user'));
        }
        elseif($user->profile->role === 'sitter') {
            return view('applications.index', compact('user'));
        }
        return view('dashboard', compact('user'))->with('error', 'You are not authorized to access this page');
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);

        if($application->sitting_request->pet->owner->id === Auth::user()->id){
            return view('applications.owner', compact('application'));
        }
        return view('dashboard')->with('error', 'You are not authorized to access this page');
    }

    public function apply(Request $request)
    {
        Log::info('function called');
        $request->validate([
            'message' => 'required|string',
        ]);
        Log::info('validated');

        $application = new Application();
        $application->sitting_request_id = $request->sittingRequest;
        $application->sitter_id = Auth::user()->id;
        $application->message = $request->message;
        $application->save();

        Log::info('application saved');

        return redirect()->route('sittingrequests.index')->with('success', 'Your application has been submitted');
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $request->validate([
            'status' => 'in:accepted,rejected',
        ]);
        $application->status = $request->status;
        $application->save();

        return redirect()->route('applications.index')->with('success', 'The application has been updated');
    }
}
