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

class Edit extends Component
{
    public $ingoingMailId, $nomor_surat, $tgl_surat, $tgl_terima, $pengirim, $perihal, $arsip, $oldArsip, $document_id, $lampiran, $formVisible = false;
    protected $listeners = ['ingoingMailEdit'];

    // Ini akan digunakan untuk mengupload gambar dan untuk preview gambar
    use WithFileUploads;

    public function render()
    {
        return view('livewire.ingoing-mail.edit', [
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

    public function Update(IngoingMail $ingoingMail)
    {
        $this->validate([
            'nomor_surat' => 'required|string|max:20|unique:ingoing_mails,nomor_surat,' . $this->ingoingMailId,
            'tgl_surat' => 'required|string',
            'pengirim' => 'required|string',
            'lampiran' => 'required|string',
            'perihal' => 'required|string',
            'document_id' => 'required|numeric',
            'arsip' => 'file|max:2048',
            'tgl_terima' => 'required|string',
        ]);

        $ingoingMail->update([
            'nomor_surat' => $this->nomor_surat,
            'tgl_surat' => $this->tgl_surat,
            'pengirim' => $this->pengirim,
            'lampiran' => $this->lampiran,
            'perihal' => $this->perihal,
            'document_id' => $this->document_id,
            'tgl_terima' => $this->tgl_terima,
        ]);

        if ($this->arsip) {
            $this->arsip->storeAs('suratMasuk', $this->arsip->getClientOriginalName(), 'public');
            $ingoingMail->update([
                'arsip' => 'suratMasuk/' . $this->arsip->getClientOriginalName(),
            ]);
            Storage::delete('suratMasuk/' . $this->oldArsip);
        }

        $this->emit('employeeAdded');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil diubah',
            'text' => ''
        ]);
    }
}
