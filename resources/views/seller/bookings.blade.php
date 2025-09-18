@extends('layouts.app')

@section('content')
<div class="bookings-container">
    <h1>Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Buyer</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->buyer->name }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ ucfirst($booking->status) }}</td>
                <td>
                    @if($booking->status == 'pending')
                    <form action="{{ route('booking.approve', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Approve</button>
                    </form>
                    <form action="{{ route('booking.decline', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Decline</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
