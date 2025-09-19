@extends('layouts.app')

@section('content')
<div class="thread-container">
    <h1>Conversation with {{ $user->name }}</h1>

    <div class="messages-box">
        @foreach($messages as $msg)
        <div class="message {{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
            <p>{{ $msg->message }}</p>
            <span class="time">{{ $msg->created_at->format('H:i') }}</span>
        </div>
        @endforeach
    </div>

    <form action="{{ route('messages.send') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <input type="text" name="message" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</div>
@endsection
