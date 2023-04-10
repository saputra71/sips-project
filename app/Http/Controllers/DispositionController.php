<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposition;

class DispositionController extends Controller
{
    public function index()
    {
        $dispositions = Disposition::where('user_id', auth()->user()->id)
            ->orWhere('sender_id', auth()->user()->id)->get();
        return view('disposisi.index', [
            'dispositions' => $dispositions
        ]);
    }

    public function show($id)
    {
        $disposition = Disposition::find($id);
        return view('disposisi.show', [
            'disposition' => $disposition
        ]);
    }
}
