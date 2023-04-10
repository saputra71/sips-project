<?php

namespace App\Http\Livewire\OutgoingMail;

use App\Models\User;
use Livewire\Component;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Menjabat;
use App\Models\Disposition;
use App\Models\OutgoingMail;
use Spatie\Permission\Models\Role;
use App\Notifications\StatusDisposisiNotification;
use Illuminate\Support\Facades\Notification;

class Create extends Component
{
    public $nomor_surat, $tgl_surat, $pengirim, $lampiran, $perihal, $menjabat_id, $document_id, $arsip, $penerima, $content, $kepada, $dasar, $reference, $user_id, $formVisible = false;

    public function render()
    {
        $documents = Document::all();
        $menjabats = Menjabat::all();
        $employees = Employee::all();
        $disposisi = Disposition::where('surat_keluar_id', null)->where('status', 'Belum Ada Balasan')->get();

        return view('livewire.outgoing-mail.create', [
            'documents' => $documents,
            'jabatans' => Role::all(),
            'employees' => $employees,
            'menjabats' => $menjabats,
            'users' => User::all(),
            'disposisi' => $disposisi,
        ]);
    }
    public function store()
    {
        $documentType = Document::find($this->document_id);
        $document = OutgoingMail::where('document_id', $documentType->id)->orderBy('id', 'desc')->first();

        if ($documentType) {
            if ($document) {
                $lastNumber = explode('/', $document->nomor_surat);
                $previousNumber = $lastNumber[2];

                $nextNumber = str_pad($previousNumber + 1, 3, '0', STR_PAD_LEFT);
                $this->nomor_surat = '421.5' . '/' . $documentType->code_number . '/' . $nextNumber . '/' . 'Smkn.11' . '/' . 'Cadisdikwill.VII' . '/' . date('Y');
            } else {
                $this->nomor_surat = '421.5' . '/' . $documentType->code_number . '/' . '001/' . 'Smkn.11' . '/' . 'Cadisdikwill.VII' . '/' . date('Y');
            }
        }

        $outgoingMail = OutgoingMail::create([
            'nomor_surat' => $this->nomor_surat,
            'tgl_surat' => $this->tgl_surat,
            'pengirim' =>  auth()->user()->id,
            'lampiran' => $this->lampiran,
            'perihal' => $this->perihal,
            'document_id' => $this->document_id,
            'penerima' => $this->penerima,
            'content' => $this->content,
            'dasar' => $this->dasar,
            'reference' => $this->reference,
            'user_id' => auth()->user()->id,
            'menjabat_id' => $this->menjabat_id,
        ]);

        $disposisi = Disposition::where('id', $this->reference)->first();

        // if reference is 0   
        if ($this->reference == 0) {
            $outgoingMail->update([
                'reference' => null,
            ]);
        } else {
            $outgoingMail->update([
                'reference' => $this->reference,
            ]);

            if ($disposisi) {
                $disposisi->update([
                    'surat_keluar_id' => $outgoingMail->id,
                    'status' => 'Diproses',
                ]);
            }
            Notification::send($disposisi->sender, new StatusDisposisiNotification($disposisi));
        }

        $this->emit('employeeAdded');
    }
}
