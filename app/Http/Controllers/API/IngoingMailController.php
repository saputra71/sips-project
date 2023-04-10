<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IngoingMail;
use App\Helpers\ResponseFormatter;
use App\Models\Disposition;
use App\Models\User;

class IngoingMailController extends Controller
{
    public function index()
    {
        $ingoingMail = IngoingMail::all();
        return ResponseFormatter::success($ingoingMail, 'Data berhasil diambil');
    }
    public function sendDisposisi()
    {
        try {
            $user = User::whereHas('roles', function ($query) {
                $query->where('name', 'kasubag');
            })->get();
            Disposition::create([
                'surat_masuk_id' => request()->surat_masuk_id,
                // 'user_id' => $user->first()->id,
                'catatan' => request()->catatan,
                'sender_id' => request()->sender_id,
            ]);

            return ResponseFormatter::success(null, 'Data berhasil dikirim');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Ada kesalahan');
        }
    }
}
