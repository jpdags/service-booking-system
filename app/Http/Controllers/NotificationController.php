<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show all notifications
    public function index()
    {
        // Get current authenticated user
        $user = Auth::user();

        // Fetch notifications for this user
        $notifications = Notification::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Mark notification as read
    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return back();
    }

    // Count unread notifications
    public static function unreadCount()
    {
        $user = Auth::user();
        if (!$user) {
            return 0;
        }

        return Notification::where('user_id', $user->id)
                            ->where('is_read', false)
                            ->count();
    }
}
