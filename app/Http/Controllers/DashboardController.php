<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sessions;
use App\Models\IngoingMail;
use App\Models\OutgoingMail;
use App\Models\Menjabat;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Disposition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\storage;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSessions = Sessions::whereNotNull('user_id')->distinct('user_id')->count();
        // $totalSuratKeluar = OutgoingMail::whereNotNull('id')->distinct('id')->count();
        $totalSuratKeluar = OutgoingMail::where('penerima', 'like', '%"' . auth()->user()->id . '"%')->count();
        // $totalSuratMasuk = IngoingMail::whereNotNull('id')->distinct('id')->count();
        $totalSuratMasuk = DB::select('CALL count_ingoing_mails()');
        $totalSuratMasuk = json_encode($totalSuratMasuk);
        $totalSuratMasuk = json_decode($totalSuratMasuk, true);
        // $totalSuratMasuk = DB::select('CALL count_ingoing_mails()');
        $notifications = auth()->user()->unreadNotifications;
        // $totalDisposisi = auth()->user()->Notifications->where('type', 'App\Notifications\NewDispoisiNotification')->count();
        // $totalDisposisi = Disposition::where('user_id', auth()->user()->id)->count();
        $totalDisposisi = Disposition::where('user_id', auth()->user()->id)
            ->orWhere('sender_id', auth()->user()->id)->count();

        $total = DB::select('SELECT count_outgoing_daily() as total');
        $user = User::find(auth()->user()->id);

        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalSessions' => $totalSessions,
            'totalSuratKeluar' => $totalSuratKeluar,
            'totalSuratMasuk' => $totalSuratMasuk,
            'notifications' => $notifications,
            'totalDisposisi' => $totalDisposisi,
            'total' =>  $total[0]->total,
        ]);
    }

    public function backup() {
        Artisan::queue('backup:run --only-db');

        $path = Storage::disk('public')->path("SIPS/*");

        $latest_ctime = 0;
        $latest_filename = '';

        $files = glob($path);

        foreach($files as $file) {
            if(is_file($file) && filectime($file) > $latest_ctime) {
                $latest_ctime = filectime($file);
                $latest_filename = ($file);
            }
        }
        return Response::download($latest_filename);
    }
    public function markNotification($id)
    {
        $user = User::find(auth()->user()->id);
        $user->unreadNotifications->where('id', $id)->markAsRead();

        return redirect()->route('index');
    }

    public function showSurat($id)
    {
        // only user with roles kasubag
        // if (auth()->user()->hasRole('kasubag')) {
        //     $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        //     $ingoingMail = IngoingMail::where('id', $notification->data['id'])->first();

        //     return view('dashboard.show', [
        //         'ingoingMail' => $ingoingMail,
        //         'notification' => $notification,
        //     ]);
        // } else {
        //     return redirect()->route('index');
        // }
        $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        try {
            if (auth()->user()->id == $notification->notifiable_id) {
                $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
                $ingoingMail = IngoingMail::where('id', $notification->data['id'])->first();

                $user = User::find(auth()->user()->id);
                $user->unreadNotifications->where('id', $id)->markAsRead();

                return view('dashboard.show', [
                    'ingoingMail' => $ingoingMail,
                    'notification' => $notification,
                ]);
            } else {
                return redirect()->route('index');
            }
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function showSuratKeluar($id)
    {
        // check if auth user id == notfiable_type id
        if (auth()->user()->id == $id) {
            $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
            $outgoingMail = OutgoingMail::where('id', $notification->data['id'])->first();

            return view('dashboard.show', [
                'outgoingMail' => $outgoingMail,
                'notification' => $notification,
            ]);
        } else {
            return redirect()->route('index');
        }
    }
}
