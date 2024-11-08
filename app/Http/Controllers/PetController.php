<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function create()
    {
        return view('pets.create');
    }

    public function index(Request $request)
    {
        $pets = Auth::user()->pets;
        if(empty($pets)){
            return view('pets.create')->with('info', 'You don\'t have any pets, make one!.');
        }
        return view('pets.index', compact('pets'));
    }

    public function edit($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->owner_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this pet.');
        }

        return view('pets.edit', compact('pet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'photo.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $pet = new Pet;
        $pet->owner_id = auth()->id();
        $pet->name = $request->name;
        $pet->species = $request->species;
        $pet->description = $request->description;
        $pet->save();

        $this->storePhoto($request, $pet);

        return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pet = Pet::findOrFail($id);

        if ($pet->owner_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update this pet.');
        }

        $pet->update($request->except('photo'));

        $this->storePhoto($request, $pet);

        return redirect()->route('pets.index', )->with('success', 'Pet updated successfully.');
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this pet.');
        }

        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
    }
    public function storePhoto(Request $request, Pet $pet): void
    {
        if($request->photo != null){
            if($pet->photo != null){
                Storage::disk('public')->delete($pet->photo);
            }
            $photo  = $request->file('photo');
            $path = $photo->store('pet_photos', 'public');
            $pet->photo = $path;
            $pet->save();
        }
    }

    public function deletePhoto(Pet $pet)
    {
        if ($pet->owner != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this pet.');
        }
        Storage::disk('public')->delete($pet->photo);
        $pet->photo = null;
        $pet->save();

        return redirect()->route('pets.index')->with('success', 'Photo deleted successfully.');
    }
}
