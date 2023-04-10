<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\IngoingMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StoreIngoingMailRequest;
use App\Notifications\NewDispoisiNotification;
use App\Notifications\NewIngoingMailNotification;
use App\Http\Requests\UpdateIngoingMailRequest;
use App\Models\Disposition;
use App\Notifications\DisposisiNotification;
use App\Exports\IngoingExport;
use Maatwebsite\Excel\Facades\Excel;

class IngoingMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

        $ingoingMails = IngoingMail::when(request()->document_id, function ($query) {
            $query->where('document_id', request()->document_id);
        })->get();


        return view('ingoing-mails.index', [
            'title' => 'Surat Masuk',
            'ingoingMails' =>   $ingoingMails,
            'documents' => $documents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingoing-mails.create', [
            'documents' => Document::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIngoingMailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngoingMailRequest $request)
    {
        $ingoingMail = IngoingMail::create($request->validated());
        $user = User::permission('ingoing-dispos')->get();
        $authUser = User::find(auth()->user()->id);

        if ($request->hasFile('arsip')) {
            $fileName = $ingoingMail->id . '-' . $request->file('arsip')->getClientOriginalName();
            $filePath = $request->file('arsip')->storeAs('suratMasuk', $fileName, 'public');
            $ingoingMail->update(['arsip' => $filePath]);
        }

        // Notification::send($user, new NewIngoingMailNotification($ingoingMail, $authUser));

        return to_route('dashboard.ingoing-mails.index')->with('success', 'Data berhasil ditambahkan');
        // return to_route('ingoing-mails.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IngoingMail  $ingoingMail
     * @return \Illuminate\Http\Response
     */

    public function show(IngoingMail $ingoingMail)
    {
        $users = User::all();

        return view('ingoing-mails.show', [
            'ingoingMail' => $ingoingMail,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IngoingMail  $ingoingMail
     * @return \Illuminate\Http\Response
     */
    public function edit(IngoingMail $ingoingMail)
    {
        return view('ingoing-mails.edit', [
            'documents' => Document::all(),
            'ingoingMail' => $ingoingMail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIngoingMailRequest  $request
     * @param  \App\Models\IngoingMail  $ingoingMail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngoingMailRequest $request, IngoingMail $ingoingMail)
    {
        $ingoingMail->update($request->validated());

        if ($request->hasFile('arsip')) {
            Storage::disk('public')->delete($ingoingMail->arsip);
            $fileName = $ingoingMail->id . '-' . $request->file('arsip')->getClientOriginalName();
            $filePath = $request->file('arsip')->storeAs('suratMasuk', $fileName, 'public');
            $ingoingMail->update(['arsip' => $filePath]);
        }

        return to_route('dashboard.ingoing-mails.index')->with('info', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IngoingMail  $ingoingMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngoingMail $ingoingMail)
    {
        $ingoingMail->delete();

        if ($ingoingMail->arsip) {
            Storage::disk('public')->delete($ingoingMail->arsip);
        }

        return to_route('dashboard.ingoing-mails.index')->with('warning', 'Data berhasil dihapus');
    }

    public function disposisi(IngoingMail $ingoingMail)
    {
        $user = User::where('id', request()->user_id)->get();

        $authUser = User::find(auth()->user()->id);
        $status = request()->status;
        $kepada = request()->user_id;
        $catatan = request()->catatan;

        $disposition = Disposition::create([
            'surat_masuk_id' => $ingoingMail->id,
            'user_id' => $user->first()->id,
            'catatan' => $catatan,
            'sender_id' => $authUser->id,
        ]);

        // send the notification to the user
        Notification::send($user, new NewDispoisiNotification($ingoingMail, $status, $kepada, $catatan, $authUser));
        Notification::send($user, new DisposisiNotification($ingoingMail, $user, $authUser));

        return to_route('dashboard.ingoing-mails.index')->with('success', 'Disposisi berhasil di kirim');
    }

    public function ingoingexport()
    {
        return Excel::download(new IngoingExport, 'ingoing.xlsx');
    }
}
