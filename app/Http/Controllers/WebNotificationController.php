<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class WebNotificationController extends Controller
{
    public function fetchNotifications()
    {
        $notifications = Notifications::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = Notifications::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
}
