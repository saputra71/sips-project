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

class Edit extends Component
{
    public $skId, $nomor_surat, $tgl_surat, $pengirim, $lampiran, $perihal, $menjabat_id, $document_id, $arsip, $penerima, $content, $kepada, $dasar, $reference, $user_id, $formVisible = false;
    protected $listeners = ['employeeEdit'];

    public function render()
    {
        return view('livewire.outgoing-mail.edit', [
            'documents' => Document::all(),
            'jabatans' => Role::all(),
            'employees' => Employee::all(),
            'menjabats' => Menjabat::all(),
            'users' => User::all(),
            'disposisi' => Disposition::where('surat_keluar_id', null)->where('status', 'Belum Ada Balasan')->get(),
        ]);
    }

    public function employeeEdit($employee)
    {
        $this->skId = $employee['id'];
        $this->nomor_surat = $employee['nomor_surat'];
        $this->pengirim = $employee['pengirim'];
        $this->lampiran = $employee['lampiran'];
        $this->perihal = $employee['perihal'];
        $this->menjabat_id = $employee['menjabat_id'];
        $this->document_id = $employee['document_id'];
        $this->penerima = $employee['penerima'];
        $this->reference = $employee['reference'];
    }
}
