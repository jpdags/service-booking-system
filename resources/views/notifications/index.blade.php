@extends('layouts.app')

@section('content')
<div class="notifications-container">
    <h1>Notifications</h1>
    <ul>
        @foreach($notifications as $note)
        <li class="{{ $note->is_read ? '' : 'unread' }}">
            {{ $note->content }}
            @if(!$note->is_read)
            <form action="{{ route('notification.read', $note->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Mark as read</button>
            </form>
            @endif
            <span class="time">{{ $note->created_at->diffForHumans() }}</span>
        </li>
        @endforeach
    </ul>
</div>
@endsection
