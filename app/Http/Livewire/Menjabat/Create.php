<?php

namespace App\Http\Livewire\Menjabat;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Create extends Component
{
      // Ini akan digunakan untuk mengupload gambar dan untuk preview gambar
      use WithFileUploads;

      public $nip, $jabatan_id, $qrCode, $menjabatId;
  
      public function render()
      {
          return view('livewire.menjabat.create', [
            'employees' => Employee::all(),
            // 'employees' => Employee::whereNotIn('nip', Menjabat::pluck('nip'))->get(),
            // 'roles' => Role::all()
            'roles' => Role::whereNotIn('id', Menjabat::where('jabatan_id', 1)->pluck('jabatan_id'))->get()
          ]);
      }
  
      public function store()
      {
        // Validasi data
        $this->validate([
            'nip' => ['required', 'numeric', 'unique:menjabats,nip'],
            'jabatan_id' => ['required', 'numeric', 'exists:jabatan,id'],
        ]);
        
        if ($this->qrCode) {
            $qrCode = $this->qrCode->storeAs('qrcode', $this->nip, 'public');
        } else {
            $qrCode = null;
        }

        // Masukkan kedalam database
        Menjabat::create([
            'nip' => $this->nip,
            'jabatan_id' => $this->jabatan_id,
            'qrcode' => $qrCode,
        ]);

        // Kirim notifikasi berhasil menggunakan emmit
        $this->emit('employeeAdded');
      }
}
