<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\SittingRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('review.index', compact('reviews'));
    }

    public function create(Application $application)
    {
        if(!empty($application->review))
        {
            return redirect()->back()->with('info', 'Review already created');
        }
        return view('review.create', compact('application'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review();
        $review->application_id = $request->application_id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->route('dashboard')->with('success', 'Review created successfully.');
    }
}
