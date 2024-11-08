<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\SittingRequest;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isNull;

class SittingRequestController extends Controller
{

    public function index(Request $request)
    {
        if($request->user()->profile->role === 'sitter') {
            $query = SittingRequest::query()->where('start_date', '>=', now());

            if ($request->filled('rate')) {
                $query->where('rate', '>=', $request->input('rate'));
            }
            if ($request->filled('start_date')) {
                $query->where('start_date', '>=', $request->input('start_date'));
            }
            if ($request->filled('end_date')) {
                $query->where('end_date', '<=', $request->input('end_date'));
            }

            $allRequests = $query->get();
            $openRequests = $allRequests->filter(function ($request) {
                return $request->applications->isEmpty() || $request->applications->where('status', 'pending')->isNotEmpty();
            });

            $user = $request->user();

            return view('sittingrequests.index', ['requests' => $openRequests, 'user' => $user]);
        }
        elseif ($request->user()->profile->role === 'owner') {
            $user = $request->user();
            $petIds= $user->pets()->pluck('id')->toArray();

            $requests = SittingRequest::whereIn('pet_id', $petIds)->get();
            return view('sittingrequests.index', ['requests' => $requests, 'user' => $user]);
        }
    }

    public function create()
    {
        $pets = Auth::user()->pets;
        return view('sittingrequests.create', compact('pets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|after_or_equal:start_date|date_format:Y-m-d',
            'message' => 'required|string',
            'rate' => 'required|numeric',
        ]);

        $request = new SittingRequest($request->all());
        $request->save();

        return redirect()->route('dashboard')->with('success', 'Pet sitting request created successfully.');
    }

    public function show($id)
    {
        $sittingRequest = SittingRequest::findOrFail($id);
        return view('sittingrequests.show', compact('sittingRequest'));
    }

    public function edit($id)
    {
        $sittingRequest = SittingRequest::findOrFail($id);
        return view('sittingrequests.edit', compact('sittingRequest'));
    }

    public function update(Request $request, $id)
    {
        $sittingRequest = SittingRequest::findOrFail($id);
        $newStatus = $request->status;

        if ($sittingRequest->owner_id == Auth::id() && $sittingRequest->status == 'open') { // owner can edit all fields, if the status field is open it is not an edit to accept or decline the request
            // update all fields except status
            $validationRules = [
                'pet_id' => 'required|exists:pets,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'message' => 'required|string',
                'rate' => 'required|numeric',
            ];
            $request->validate($validationRules);
            $sittingRequest->update($request->only([
                'pet_id',
                'start_date',
                'end_date',
                'message',
                'rate',
            ]));


            return redirect()->route('dashboard')->with('success', 'Pet sitting request updated successfully.');

        } elseif ($sittingRequest->owner_id == Auth::id() && $sittingRequest->status == 'pending' && in_array($newStatus, ['accepted', 'rejected'])) {
            // owner can only change message and status, because people have already applied
            $validationRules = [
                'message' => 'required|string',
                'status' => 'in:accepted,rejected',
            ];
            $request->validate($validationRules);
            if($newStatus == 'rejected') {
                // todo: figure out how to delete the application
            }
            $sittingRequest->update($request->only([
                'message',
                'status',
            ]));

            return redirect()->route('dashboard')->with('success', "Pet sitting {$newStatus} successfully.");

        } elseif ($sittingRequest->sitter_id == Auth::id() && $sittingRequest->status == 'open') { // sitter can only edit status and sitter id
            $validationRules = [
                'status' => 'in:pending',
                'sitter_id' => 'required|exists:users,id',
            ];
            $request->validate($validationRules);
            $sittingRequest->update($request->only(
                'status',
                'sitter_id'
            ));

            // todo: create application



            return redirect()->route('dashboard')->with('success', 'Pet sitting request made pending successfully.');
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this request.');
        }
    }

    public function destroy($id)
    {
        $request = SittingRequest::findOrFail($id);

        if ($request->owner_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this request.');
        }

        //todo: remove applications associated with request

        $request->delete();

        return redirect()->route('dashboard')->with('success', 'Pet sitting request deleted successfully.');
    }
}
