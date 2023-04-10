<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use App\Models\User;

class Edit extends Component
{
    public $name, $email, $password, $password_confirmation, $role, $userId;

    // Untuk mengambil emit yang dikirim dari komponen index
    protected $listeners = ['employeeEdit'];

    public function render()
    {
        return view('livewire.user.edit', [
            'roles' => Role::all()
        ]);
    }

    // Untuk handle emit dari komponen index
    public function employeeEdit($user)
    {
        // Isi properti yang sudah dideklarasikan sebelumnya menggunakan data dari emit
        $this->userId = $user['id'];
        $this->name = $user['name'];
        $this->email = $user['email'];
    }

    // Update data
    public function update(User $user)
    {
        // Validasi
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->userId . ',id'],
            'role' => ['required', 'numeric', 'exists:jabatan,id'],
        ]);

        // Update ke database
        // $user->update([
        //     'name' => $this->name,
        //     'email' => $this->email,
        // ])->assignRole($this->role);

        // Emit untuk trigger notifikasi
        $this->emit('employeeEdited');
    }
}
