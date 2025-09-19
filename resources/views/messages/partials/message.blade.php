<div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
    <p>{{ $message->message }}</p>
    <div class="timestamp">{{ $message->created_at->format('M d, Y H:i') }}</div>

    @if($message->replies->count())
        <div class="reply-thread">
            @foreach($message->replies as $reply)
                @include('messages.partials.message', ['message' => $reply])
            @endforeach
        </div>
    @endif
</div>
