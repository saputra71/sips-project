<?php

namespace App\Http\Livewire\Menjabat;

use Livewire\Component;
use App\Models\Menjabat;
use Livewire\WithPagination;
Use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Employee;

class Index extends Component
{
    // Gunakan ini agar menggunakan pagination milik livewire
    use WithPagination;

    public $paginate = 10, $search, $formVisible = false;

    public $confirmingMenjabatDeletion = false;

    // Untuk mengupdate 'search' yang ada di url
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // Membuat listener untuk emit yang dibuat di komponen lain
    protected $listeners = ['employeeAdded', 'closeForm', 'employeeEdited'];

    public function render()
    {
        return view('livewire.menjabat.index', [
            'menjabat' => $this->search 
                                ? Menjabat::where('nip', 'like', '%' . $this->search . '%')
                                ->latest()->paginate($this->paginate)
                                : Menjabat::latest()->paginate($this->paginate),
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
        session()->flash('message', 'Menjabat added successfully');
        // Tutup form
        $this->closeForm();
    }

    // Untuk menutup form
    public function closeForm()
    {
        $this->formVisible = false;
    }

    // Untuk menghapus data
    public function destroy(Menjabat $menjabat)
    {
        $menjabat->delete();

        if ($menjabat->qrcode) {
            Storage::disk('public')->delete($menjabat->qrcode);
        }

        $this->confirmingMenjabatDeletion = false;

        // Untuk memberi notifikasi
        session()->flash('message', 'Menjabat deleted successfully');
    }

    // Untuk menampilkan form edit
    public function edit(Menjabat $menjabat)
    {
        $this->formVisible = 'edit';
        // Untuk mengirim data student yang di klik ke komponen lain (komponen edit)
        $this->emit('employeeEdit', $menjabat);
    }

    // Untuk menampilkan notifikasi dari emit yang dikirim dari komponen edit
    public function employeeEdited()
    {
        session()->flash('message', 'Menjabat edited successfully');
        // Tutup form
        $this->closeForm();
    }

    public function confirmMenjabatDeletion( $id )
    {
        $this->confirmingMenjabatDeletion = $id;
    }
}
