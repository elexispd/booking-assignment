<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|string',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'rider_id' => null,
            'item' => $request->item,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'status' => 'pending',
        ]);

        return response()->json($booking, 201);
    }

    public function index()
    {
        if(auth()->user()->role === 'rider') {
            $bookings = Booking::where('status', 'pending')->get();
        } else {
            $bookings = Booking::where('user_id', auth()->id())->get();
        }
        return response()->json($bookings);
    }

    public function accept(Booking $booking)
    {
        $booking->update([
            'rider_id' => auth()->id(),
            'status' => 'accepted',
        ]);

        return response()->json($booking);
    }

    public function complete(Booking $booking)
    {
        if (auth()->user()->id !== $booking->user_id) {
            return response()->json(['message' => 'You are not authorized to complete this booking.'], 403);
        }

        if ($booking->status === 'completed') {
            return response()->json(['message' => 'Booking already completed.'], 403);
        }

        if (is_null($booking->rider_id)) {
            return response()->json(['message' => 'Booking not yet accepted by a rider.'], 403);
        }

        $booking->update(['status' => 'completed']);

        return response()->json(['message' => 'Booking completed successfully.', 'data' => $booking], 200);
    }



}
