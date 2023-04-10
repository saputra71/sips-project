<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use App\Models\User;

class Create extends Component
{
    public $name, $email, $password, $password_confirmation, $role, $userId;

    public function render()
    {
        return view('livewire.user.create', [
            'roles' => Role::all()
        ]);
    }

    public function store()
    {
        // Validasi data
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'numeric', 'exists:jabatan,id'],
        ]);

        // Masukkan kedalam database
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ])->assignRole($this->role);

        // Kirim notifikasi berhasil menggunakan emmit
        $this->emit('employeeAdded');
    }
}
