<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class NotificationController extends Controller
{
    public function index() {
        $notifications = NotificationHelper::getAll();
        $unread = NotificationHelper::getUnreadCount();
        return view('notifications.index', compact('notifications', 'unread'));
    }

    public function clearAll() {
        NotificationHelper::clearAll();
        return back()->with('success', 'Semua notifikasi dihapus');
    }
}
