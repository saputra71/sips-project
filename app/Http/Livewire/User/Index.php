<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use App\Models\User;

class Index extends Component
{
    // Gunakan ini agar menggunakan pagination milik livewire
    use WithPagination;

    public $paginate = 10, $search, $formVisible = false;

    public $confirmingUserDeletion = false;

    // Untuk mengupdate 'search' yang ada di url
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // Membuat listener untuk emit yang dibuat di komponen lain
    protected $listeners = ['employeeAdded', 'closeForm', 'employeeEdited'];

    public function render()
    {
        return view('livewire.user.index', [
            'users' => $this->search
                ? User::where('name', 'like', '%' . $this->search . '%')
                ->latest()->paginate($this->paginate)
                : User::oldest()->paginate($this->paginate),
        ]);
    }
    // Untuk menampilkan form tambah
    public function create()
    {
        $this->formVisible = 'create';
    }

    // Untuk menampilkan notifikasi dari emit yang dikirim dari komponen create
    public function employeeAdded()
    {
        session()->flash('message', 'User added successfully');
        // Tutup form
        $this->closeForm();
    }

    // Untuk menutup form
    public function closeForm()
    {
        $this->formVisible = false;
    }

    // Untuk menghapus data
    public function destroy(User $user)
    {
        $user->delete();

        $this->confirmingUserDeletion = false;

        // Untuk memberi notifikasi
        session()->flash('message', 'User deleted successfully');
    }

    // Untuk menampilkan form edit
    public function edit(User $user)
    {
        $this->formVisible = 'edit';
        // Untuk mengirim data student yang di klik ke komponen lain (komponen edit)
        $this->emit('employeeEdit', $user);
    }

    // Untuk menampilkan notifikasi dari emit yang dikirim dari komponen edit
    public function employeeEdited()
    {
        session()->flash('message', 'User edited successfully');
        // Tutup form
        $this->closeForm();
    }

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = $id;
    }
}
