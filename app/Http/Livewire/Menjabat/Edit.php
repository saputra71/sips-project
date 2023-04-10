<?php

namespace App\Http\Livewire\Menjabat;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class Edit extends Component
{
     // Ini akan digunakan untuk mengupload gambar dan untuk preview gambar
    use WithFileUploads;

    public $nip, $jabatan_id, $qrCode, $photoOld ,$menjabatId;

    // Untuk mengambil emit yang dikirim dari komponen index
    protected $listeners = ['employeeEdit'];
    
    public function render()
    {
        return view('livewire.menjabat.edit', [
            'employees' => Employee::all(),
            'roles' => Role::all()
        ]);
    }

    // Untuk handle emit dari komponen index
    public function employeeEdit($menjabat)
    {
        // Isi properti yang sudah dideklarasikan sebelumnya menggunakan data dari emit
        $this->menjabatId = $menjabat['id'];
        $this->nip = $menjabat['nip'];
        $this->jabatan_id = $menjabat['jabatan_id'];
        $this->photoOld = $menjabat['qrcode'];
    }

    // Update data
    public function update(Menjabat $menjabat)
    {
        // Validasi
        $this->validate([
            'nip' => 'required|numeric|unique:menjabats,nip,' . $this->menjabatId . ',id',
        ]);

        if($this->jabatan_id == 1 || $this->jabatan_id == 2) {
            $this->validate([
                'jabatan_id' => 'required|numeric|unique:menjabats,jabatan_id,' . $this->menjabatId . ',id'
            ]);
        } else {
            $this->validate([
                'jabatan_id' => 'required|numeric'
            ]);
        }

        if ($this->qrCode) {
            $qrCode = $this->qrCode->storeAs('qrcode', $this->nip, 'public');
            if (preg_match('/upload/', $menjabat->qrCode)) {
                Storage::delete($menjabat->qrCode);
            }
        } else {
            $qrCode = $this->photoOld;
        }

        // Update ke database
        $menjabat->update([
            'nip' => $this->nip,
            'jabatan_id' => $this->jabatan_id,
            'qrcode' => $qrCode,
        ]);

        // Emit untuk trigger notifikasi
        $this->emit('employeeEdited');
    }
}
