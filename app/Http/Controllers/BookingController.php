<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Buyer: request a service
    public function requestService($serviceId)
    {
        $service = Service::findOrFail($serviceId);

        Booking::create([
            'buyer_id' => Auth::id(),
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Booking request sent!');
    }

    // Seller: view all bookings
    public function indexSeller()
    {
        $bookings = Booking::whereHas('service', function($q){
            $q->where('seller_id', Auth::id());
        })->orderBy('created_at', 'desc')->get();

        return view('seller.bookings', compact('bookings'));
    }

    // Seller: approve booking
    public function approve($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'approved';
        $booking->save();

        // Create notification for buyer
        Notification::create([
            'user_id' => $booking->buyer_id,
            'type' => 'booking',
            'content' => "Your booking for {$booking->service->name} has been {$booking->status}."
        ]);

        return back()->with('success', 'Booking approved!');
    }

    // Seller: decline booking
    public function decline($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'declined';
        $booking->save();

        // Create notification for buyer
        Notification::create([
            'user_id' => $booking->buyer_id,
            'type' => 'booking',
            'content' => "Your booking for {$booking->service->name} has been {$booking->status}."
        ]);

        return back()->with('success', 'Booking declined!');
    }

    // Buyer: view own bookings
    public function indexBuyer()
    {
        $bookings = Booking::where('buyer_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('buyer.bookings', compact('bookings'));
    }
}
