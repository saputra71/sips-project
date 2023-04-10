<?php

namespace App\Http\Livewire\IngoingMail;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Document;
use App\Models\IngoingMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewDispoisiNotification;

class Disposisi extends Component
{
    public $ingoingMailId, $nomor_surat, $tgl_surat, $tgl_terima, $pengirim, $perihal, $arsip, $oldArsip, $document_id, $lampiran, $formVisible = false;
    protected $listeners = ['ingoingMailEdit'];

    public function render()
    {
        return view('livewire.ingoing-mail.disposisi', [
            'documents' => Document::all(),
        ]);
    }

    public function ingoingMailEdit($ingoingMail)
    {
        $this->ingoingMailId = $ingoingMail['id'];
        $this->nomor_surat = $ingoingMail['nomor_surat'];
        $this->tgl_surat = $ingoingMail['tgl_surat'];
        $this->pengirim = $ingoingMail['pengirim'];
        $this->lampiran = $ingoingMail['lampiran'];
        $this->perihal = $ingoingMail['perihal'];
        $this->document_id = $ingoingMail['document_id'];
        $this->tgl_terima = $ingoingMail['tgl_terima'];
        $this->arsip = $ingoingMail['arsip'];
    }
}
