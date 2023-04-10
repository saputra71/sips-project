<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.notification.index', [
            'notifications' => auth()->user()->notifications,
            'todayNotifications' => auth()->user()->notifications->where('created_at', '>=', now()->startOfDay()),
        ]);
    }
}
