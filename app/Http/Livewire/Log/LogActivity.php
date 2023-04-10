<?php

namespace App\Http\Livewire\Log;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class LogActivity extends Component
{
    public function render()
    {
        $logs = Activity::all();
        return view('livewire.log.log-activity', [
            'logs' => $logs,
        ]);
    }

}
