<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Show form for review
    public function create($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        return view('buyer.review', compact('booking'));
    }

    // Store review
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $booking = Booking::findOrFail($bookingId);

        Review::create([
            'booking_id' => $booking->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $booking->service->seller_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('buyer.bookings')->with('success', 'Review submitted!');
    }
}
