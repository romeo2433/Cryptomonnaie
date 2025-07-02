<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Afficher les notifications
    public function index()
    {
        $notifications = auth()->check() ? auth()->user()->notifications : collect([]);
        return view('notifications.index', compact('notifications'));
    }

    // Marquer une notification comme lue
    public function markAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('notifications.index')->with('success', 'Notifications marquées comme lues.');
    }
}