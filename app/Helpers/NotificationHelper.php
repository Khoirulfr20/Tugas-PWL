<?php
namespace App\Helpers;

use Carbon\Carbon;

class NotificationHelper {
    public static function getAll() {
        return session()->get('notifications', []);
    }

    public static function add($type, $title, $message, $data = []) {
        $notifications = self::getAll();
        $notifications[] = [
            'id' => uniqid(),
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'time' => Carbon::now()->toDateTimeString(),
            'time_ago' => Carbon::now()->diffForHumans(),
        ];
        session()->put('notifications', $notifications);
    }

    public static function getUnreadCount() {
        $all = self::getAll();
        $readIds = session()->get('read_notifications', []);
        return count(array_filter($all, fn($n) => !in_array($n['id'], $readIds)));
    }

    public static function clearAll() {
        session()->forget(['notifications', 'read_notifications']);
    }

    public static function getIcon($type) {
        $icons = [
            'info' => 'fas fa-info-circle',
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
        ];
        return $icons[$type] ?? 'fas fa-bell';
    }
}
