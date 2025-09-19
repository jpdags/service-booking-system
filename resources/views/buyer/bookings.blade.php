@extends('layouts.app')

@section('content')
<div class="bookings-container">
    <h1>My Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Seller</th>
                <th>Date</th>
                <th>Status</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->service->seller->name }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ ucfirst($booking->status) }}</td>
                <td>
                    @if($booking->status == 'approved')
                    <a href="{{ route('review.create', $booking->id) }}">Leave Review</a>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
