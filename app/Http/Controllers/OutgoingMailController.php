<?php

namespace App\Http\Controllers;

use App\Models\OutgoingMail;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOutgoingMailRequest;
use App\Http\Requests\UpdateOutgoingMailRequest;
use App\Models\OutgoingMailDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Models\Disposition;
use App\Notifications\StatusDisposisiNotification;
use Termwind\Components\Dd;

class OutgoingMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outgoingMails = OutgoingMailDetail::where('penerima', auth()->user()->id)->get();

        return view('outgoing-mails.index', [
            'title' => 'Surat Keluar',
            'outgoingMails' => $outgoingMails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::all();
        $employees = Employee::all();
        // $disposisi = Disposition::where('surat_keluar_id', null)->where('status', 'Belum Ada Balasan')->get();
        $disposisi = Disposition::where('surat_keluar_id', null)->where('status', 'Belum Ada Balasan')->where('user_id', auth()->user()->id)->get();

        return view('outgoing-mails.create', [
            'documents' => $documents,
            'jabatans' => Role::all(),
            'employees' => $employees,
            'users' => User::all(),
            'disposisi' => $disposisi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOutgoingMailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOutgoingMailRequest $request)
    {
        $documentType = Document::find($request->document_id);
        $document = OutgoingMail::where('document_id', $documentType->id)->orderBy('id', 'desc')->first();

        if ($documentType) {
            if ($document) {
                $lastNumber = explode('/', $document->nomor_surat);
                $previousNumber = $lastNumber[2];

                $nextNumber = str_pad($previousNumber + 1, 3, '0', STR_PAD_LEFT);
                $number = '421.5' . '/' . $documentType->code_number . '/' . $nextNumber . '/' . 'Smkn.11' . '/' . 'Cadisdikwill.VII' . '/' . date('Y');
            } else {
                $number = '421.5' . '/' . $documentType->code_number . '/' . '001/' . 'Smkn.11' . '/' . 'Cadisdikwill.VII' . '/' . date('Y');
            }
        }
        // store the data with nomor_surat = $number
        $outgoingMail = OutgoingMail::create([
            'nomor_surat' => $number,
            'tgl_surat' => $request->tgl_surat,
            'perihal' => $request->perihal,
            'menjabat_id' => $request->menjabat_id,
            'document_id' => $request->document_id,
            'penerima' => $request->penerima,
            'lampiran' => $request->lampiran,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'pengirim' => auth()->user()->id,
        ]);
        $disposisi = Disposition::where('id', $request->reference)->first();
        // dd($disposisi->sender);

        if ($request->reference == 0) {
            $outgoingMail->update([
                'reference' => null,
            ]);
        } else {
            $outgoingMail->update([
                'reference' => $request->reference,
            ]);

            if ($disposisi) {
                $disposisi->update([
                    'surat_keluar_id' => $outgoingMail->id,
                    'status' => 'Diproses'
                ]);
            }

            // dd($disposisi);
            Notification::send($disposisi->sender, new StatusDisposisiNotification($disposisi));
        }

        if ($request->hasFile('arsip')) {
            $fileName = $outgoingMail->id . '-' . $request->file('arsip')->getClientOriginalName();
            $filePath = $request->file('arsip')->storeAs('suratKeluar', $fileName, 'public');
            $outgoingMail->update(['arsip' => $filePath]);
        }

        // return to_route('dashboard.outgoing-mails.index')->with('success', 'Data berhasil ditambahkan');
        return redirect()->route('dashboard.outgoing-mails.show', $outgoingMail->id)->with('message', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OutgoingMail  $outgoingMail
     * @return \Illuminate\Http\Response
     */
    public function show(OutgoingMail $outgoingMail)
    {
        $employees = Employee::all();

        return view('outgoing-mails.show', [
            'documents' => Document::all(),
            'outgoingMail' => $outgoingMail,
            'employees' => $employees,
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutgoingMail  $outgoingMail
     * @return \Illuminate\Http\Response
     */
    public function edit(OutgoingMail $outgoingMail)
    {
        if ($outgoingMail->user_id != auth()->user()->id) {
            return abort(403);
        } else {
            $employees = Employee::all();

            return view('outgoing-mails.edit', [
                'documents' => Document::all(),
                'outgoingMail' => $outgoingMail,
                'employees' => $employees,
                'users' => User::all(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOutgoingMailRequest  $request
     * @param  \App\Models\OutgoingMail  $outgoingMail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOutgoingMailRequest $request, OutgoingMail $outgoingMail)
    {
        if ($outgoingMail->user_id != auth()->user()->id) {
            return abort(403);
        } else {
            $outgoingMail->update($request->validated());

            // $fileName = $outgoingMail->id . '-' . $outgoingMail->document->code_number . '-' . $outgoingMail->document->name . '.pdf';
            $documentName = str_replace(' ', '', $outgoingMail->document->name);
            $fileName = $outgoingMail->id . '-' . $outgoingMail->document->code_number . '-' . $documentName . '.pdf';

            $nomor_surat = $request->nomor_surat;
            $lampiran = $outgoingMail->lampiran;
            $perihal = $outgoingMail->perihal;
            $isi = $request->content;
            $nama = $outgoingMail->penerima;
            $nama_penandatangan = $outgoingMail->menjabat->name;
            $nip = $outgoingMail->menjabat->nip;
            $tanggal = Carbon::parse($outgoingMail->tgl_surat)->translatedFormat('d F Y');
            $qrPath = $outgoingMail->menjabat->sign;
            // dd(Storage::url($qrPath));
            // $qr_code =  asset('storage/'.$qrPath);
            // $qr_code = public_path("storage/" . $qrPath);
            $qr_code =  asset('storage/template/' . $fileName);
            // dd($qr_code);

            $users = User::all();

            $pdf = Pdf::loadView('template-surat.surat', compact('nomor_surat', 'perihal', 'isi', 'nama', 'nama_penandatangan', 'qr_code', 'nip', 'tanggal', 'lampiran', 'users'));

            $savePdfPath = storage_path('app/public/template/' . $fileName);
            $pdf->save($savePdfPath);

            $outgoingMail->update([
                'arsip' => 'template/' . $fileName,
                'content' => $request->content,
            ]);
        }
        return redirect()->route('dashboard.outgoing-mails.view-template', $outgoingMail->id)->with('message', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutgoingMail  $outgoingMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutgoingMail $outgoingMail)
    {
        $outgoingMail->delete();

        if ($outgoingMail->arsip) {
            Storage::disk('public')->delete($outgoingMail->arsip);
        }

        return redirect()->route('dashboard.outgoing-mails.index')->with('message', 'Data berhasil dihapus');
    }

    public function templateSuratEdaran(Request $request, OutgoingMail $outgoingMail)
    {
        $documentName = str_replace(' ', '', $outgoingMail->document->name);
        $fileName = $outgoingMail->id . '-' . $outgoingMail->document->code_number . '-' . $documentName . '.pdf';

        $nomor_surat = $request->nomor_surat;
        $lampiran = $outgoingMail->lampiran;
        $perihal = $outgoingMail->perihal;
        $isi = $request->content;
        $nama = $outgoingMail->penerima;
        $nama_penandatangan = $outgoingMail->menjabat->name;
        $nip = $outgoingMail->menjabat->nip;
        $tanggal = Carbon::parse($outgoingMail->tgl_surat)->translatedFormat('d F Y');
        $qrPath = $outgoingMail->menjabat->sign;
        // dd(Storage::url($qrPath));
        $qr_code =  asset('storage/template/' . $fileName);
        // $qr_code = public_path("storage/" . $fileName);

        $users = User::all();

        $pdf = Pdf::loadView('template-surat.surat', compact('nomor_surat', 'perihal', 'isi', 'nama', 'nama_penandatangan', 'qr_code', 'nip', 'tanggal', 'lampiran', 'users'));

        $savePdfPath = storage_path('app/public/template/' . $fileName);
        $pdf->save($savePdfPath);

        $outgoingMail->update([
            'arsip' => 'template/' . $fileName,
            'content' => $request->content,
        ]);

        // change status on dispositions
        $dispositions = Disposition::where('surat_keluar_id', $outgoingMail->id)->get();

        if ($dispositions->count() > 0) {
            foreach ($dispositions as $disposition) {
                $disposition->update([
                    'status' => 'SELESAI',
                ]);
            }
            $disposisi = $dispositions->first();
            // dd($disposisi->sender);
            Notification::send($disposisi->sender, new StatusDisposisiNotification($disposisi));
        }
        // foreach ($dispositions as $disposition) {
        //     $disposition->update([
        //         'status' => 'SELESAI',
        //     ]);
        // }

        return redirect()->route('dashboard.outgoing-mails.index')->with('message', 'Data berhasil ditambahkan');
    }

    public function viewTemplate($outgoingMail)
    {
        // check if user id is not in array of penerima or sender then redirect to 404
        $outgoingMail = OutgoingMail::find($outgoingMail);
        $receiver = $outgoingMail->penerima;
        $sender = $outgoingMail->pengirim;
        $user = auth()->user()->id;

        if (!in_array($user, $receiver) && $user != $sender) {
            return abort(404);
        }

        // $outgoingMail = OutgoingMail::find($outgoingMail);

        return view('outgoing-mails.view-template', [
            'outgoingMail' => $outgoingMail,
        ]);
    }

    public function view($outgoingMail)
    {
        $outgoingMail = OutgoingMail::find($outgoingMail);

        return view('outgoing-mails.view', [
            'outgoingMail' => $outgoingMail,
        ]);
    }
}
