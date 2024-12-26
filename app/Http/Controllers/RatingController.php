<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use App\Models\User;
use App\Models\Booking;


class RatingController extends Controller
{

    public function store(RatingRequest $request) {
        $request->validated($request->all());
        $rating = Rating::create([
            'user_id' => auth()->id(),
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->status !== 'completed') {
            $booking->update(['status' => 'completed']);
        }

        return response()->json($rating, 201);
    }

    public function show(User $rider) {
        $ratings = $rider->ratings()->get();
        $averageRating = $rider->averageRating();
        return response()->json(['ratings' => $ratings,
        'average_rating' => $averageRating,], 200);
    }
}
