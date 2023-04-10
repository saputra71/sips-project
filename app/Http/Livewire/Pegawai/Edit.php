<?php

namespace App\Http\Livewire\Pegawai;

use Livewire\Component;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    // Ini akan digunakan untuk mengupload gambar dan untuk preview gambar
    use WithFileUploads;

    public $nip, $name, $address, $phone, $employeeId, $sign, $jabatan, $email, $oldSign;

    // Untuk mengambil emit yang dikirim dari komponen index
    protected $listeners = ['employeeEdit'];

    public function render()
    {
        return view('livewire.pegawai.edit', [
            'roles' => Role::all()
        ]);
    }

    // Untuk handle emit dari komponen index
    public function employeeEdit($employee)
    {
        // Isi properti yang sudah dideklarasikan sebelumnya menggunakan data dari emit
        $this->employeeId = $employee['nip'];
        $this->nip = $employee['nip'];
        $this->name = $employee['name'];
        $this->address = $employee['address'];
        $this->phone = $employee['phone'];
        $this->jabatan = $employee['jabatan'];
        $this->email = $employee['email'];
    }

    // Update data
    public function update(Employee $employee)
    {
        // Validasi
        $this->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => 'required|numeric|digits_between:10,13|unique:employees,phone,' . $this->nip . ',nip',
            'email' => 'required|email|unique:users,email,' . $this->nip . ',karyawan_id',
        ]);

        if ($this->jabatan == 1 || $this->jabatan == 2) {
            $this->validate([
                'jabatan' => 'required|numeric|unique:employees,jabatan,' . $this->employeeId . ',nip'
            ]);
        } else {
            $this->validate([
                'jabatan' => 'required|numeric'
            ]);
        }

        if ($this->sign) {
            $sign = $this->sign->storeAs('qrcode', $this->nip, 'public');
            if (preg_match('/upload/', $employee->sign)) {
                Storage::delete($employee->sign);
            }
        } else {
            $sign = $this->oldSign;
        }

        // Update ke database
        $employee->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'jabatan' => $this->jabatan,
        ]);


        // update to Users
        $user = User::where('karyawan_id', $this->nip)->first();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->syncRoles($this->jabatan);

        // Emit untuk trigger notifikasi
        $this->emit('employeeEdited');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil diubah',
            'text' => ''
        ]);
    }
}
