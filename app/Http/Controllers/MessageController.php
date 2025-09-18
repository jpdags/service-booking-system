<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Show all message threads
    public function index()
    {
        $userId = Auth::id();

        $threads = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($msg) {
                return $msg->sender_id == Auth::id() ? $msg->receiver_id : $msg->sender_id;
            });

        return view('messages.index', compact('threads'));
    }

    // Show a specific conversation thread
    public function thread($userId)
    {
        $authId = Auth::id();

        $messages = Message::where(function($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        $user = User::findOrFail($userId);

        return view('messages.thread', compact('messages', 'user'));
    }

    // Send a new message
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Create a notification for the receiver
        Notification::create([
            'user_id' => $request->receiver_id,
            'type' => 'message',
            'content' => "New message from " . Auth::user()->name,
        ]);

        return back();
    }
}
