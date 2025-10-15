@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fas fa-bell"></i> Notifikasi</h3>
        <form method="POST" action="{{ route('notifications.clear') }}">
            @csrf
            <button class="btn btn-danger btn-sm" type="submit">
                <i class="fas fa-trash"></i> Hapus Semua
            </button>
        </form>
    </div>

    @if(count($notifications))
        <div class="list-group">
            @foreach(array_reverse($notifications) as $notif)
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <i class="{{ \App\Helpers\NotificationHelper::getIcon($notif['type']) }} text-primary"></i>
                        <strong>{{ $notif['title'] }}</strong><br>
                        <small>{{ $notif['message'] }}</small>
                    </div>
                    <small class="text-muted">{{ $notif['time_ago'] }}</small>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bell-slash fa-3x"></i>
            <p class="mt-2">Belum ada notifikasi</p>
        </div>
    @endif
</div>
@endsection
