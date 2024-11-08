<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\House;
use App\Models\HousePhoto;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function create()
    {
        $existingHouse = Auth::user()->house;
        if (!empty($existingHouse)) {
            return redirect()->route('houses.edit', $existingHouse->id)->with('info', 'You already have a house. You can edit it here.');
        }
        return view('houses.create');
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);

        if ($house->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this house.');
        }

        $photos = HousePhoto::where('house_id', $id)->get();

        return view('houses.edit', compact('house', 'photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
        ]);



        $house = new House();
        $house->user_id = Auth::id();
        $house->fill($request->except('photos'));
        $house->save();



        if($request->photos != null) {
            $this->storePhotos($request, $house);
        }

        return redirect()->route('houses.edit', compact('house'))->with('info', 'House created.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'description' => 'string|max:255',
            'photos' => 'nullable|array'
        ]);


        $house = House::findOrFail($id);

        if ($house->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this house.');
        }

        $house->update($request->except('photos'));

        if($request->photos != null) {
            $this->storePhotos($request, $house);
        }

        return redirect()->route('houses.edit', compact('house'))->with('info', 'House successfully updated');
    }

    public function destroy($id)
    {
        $house = House::findOrFail($id);

        if ($house->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this house.');
        }

        $house->delete();

        return redirect()->route('dashboard')->with('success', 'House deleted successfully.');
    }

    public function storePhotos(Request $request, House $house)
    {
        foreach ($request->photos as $photo) {
            if ($photo) {
                $path = $photo->store('house_photos', 'public');

                $housePhoto = new HousePhoto();
                $housePhoto->house_id = $house->id;
                $housePhoto->url = $path;
                $housePhoto->save();
            }
        }
    }

    public function deletePhoto($id)
    {
        $photo = HousePhoto::findOrFail($id);
        $house = $photo->house;

        if ($house->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this photo.');
        }

        // Delete the photo from storage
        Storage::disk('public')->delete($photo->url);
        $photo->delete();

        return redirect()->back()->with('success', 'Photo deleted successfully.');
    }
}
