<?php

namespace App\Http\Livewire\Pegawai;

use App\Models\User;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    // Ini akan digunakan untuk mengupload gambar dan untuk preview gambar
    use WithFileUploads;

    public $name, $nip, $address, $phone, $password, $sign, $password_confirmation, $karyawan_id, $jabatan, $email;

    public function render()
    {
        return view('livewire.pegawai.create', [
            'roles' => Role::all()
        ]);
    }

    public function store()
    {
        // Validasi data
        $this->validate([
            'nip' => ['required', 'numeric', 'unique:employees,nip'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'numeric', 'digits_between:10,13', 'unique:employees,phone'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        // if jabaran id = 1 & 2 then apply unique validation for jabatan
        if ($this->jabatan == 1 || $this->jabatan == 2) {
            $this->validate([
                'jabatan' => ['unique:employees,jabatan'],
            ]);
        }


        if ($this->sign) {
            $sign = $this->sign->storeAs('qrcode', $this->nip, 'public');
        } else {
            $sign = null;
        }

        // insert value for validate password is secret
        $this->password = bcrypt('secret');

        $generatePassword = bcrypt('12345678');
        // Masukkan kedalam database
        Employee::create([
            'nip' => $this->nip,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'password' => $this->password,
            'email' => $this->email,
            'jabatan' => $this->jabatan,
        ]);

        // Store to Users
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'karyawan_id' => $this->nip,
        ])->assignRole($this->jabatan);

        // Kirim notifikasi berhasil menggunakan emmit
        $this->emit('employeeAdded');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'text' => ''
        ]);
    }
}
