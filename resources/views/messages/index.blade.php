@extends('layouts.app')

@section('content')
<div class="messages-container">
    <h1>Message Threads</h1>
    <ul>
        @foreach($threads as $threadUserId => $messages)
        @php $user = \App\Models\User::find($threadUserId); @endphp
        <li>
            <a href="{{ route('messages.thread', $user->id) }}">
                {{ $user->name }}
                <span class="latest">{{ $messages->last()->message }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
