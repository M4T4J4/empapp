<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(20);
        return view('notification.index', compact('notifications'));
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marquée comme lue!');
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Toutes les notifications marquées comme lues!');
    }

    public function destroy($notificationId)
    {
        Auth::user()->notifications()->findOrFail($notificationId)->delete();
        return redirect()->back()->with('success', 'Notification supprimée!');
    }
}
