<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    // GET /api/notifications
    public function index()
    {
        return Notification::orderBy('created_at', 'desc')->get();
    }

    // PUT /api/notifications/{id}/read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return $notification;
    }

    // PUT /api/notifications/read-all
    public function markAllAsRead()
    {
        Notification::where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
