<?php

namespace App\Http\Livewire\OutgoingMail;

use Livewire\Component;
use App\Models\OutgoingMail;
use Livewire\WithPagination;
use App\Models\Document;

class Index extends Component
{
    // Gunakan ini agar menggunakan pagination milik livewire
    use WithPagination;

    public $paginate = 10, $search, $formVisible = false, $sort;
    public $confirmingOutgoingMailDeletion = false;
    // Untuk mengupdate 'search' yang ada di url
    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => ''],
    ];

    // Membuat listener untuk emit yang dibuat di komponen lain
    protected $listeners = ['employeeAdded', 'closeForm', 'employeeEdited', 'destroy'];

    public function render()
    {
        return view('livewire.outgoing-mail.index', [
            'outgoingMails' => $this->search
                ? OutgoingMail::where('pengirim', auth()->user()->id)
                ->where(function ($query) {
                    $query->where('nomor_surat', 'like', '%' . $this->search . '%')
                        ->orWhere('perihal', 'like', '%' . $this->search . '%')
                        ->orWhere('tgl_surat', 'like', '%' . $this->search . '%');
                })->latest()->paginate($this->paginate)
                : OutgoingMail::where('pengirim', auth()->user()->id)
                ->where('document_id', 'like', '%' . $this->sort . '%')
                ->latest()
                ->paginate($this->paginate),
            'documents' => Document::all(),
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
        // open edit form and show data
        $this->formVisible = 'show';
        $this->emit('employeeEdit', OutgoingMail::latest()->first());
    }

    // Untuk menutup form
    public function closeForm()
    {
        $this->formVisible = false;
    }

    // Untuk menghapus data
    public function destroy(OutgoingMail $student)
    {
        $student->delete();

        $this->confirmingOutgoingMailDeletion = false;

        // Untuk memberi notifikasi
        session()->flash('message', 'OutgoingMail deleted successfully');
    }

    // Untuk menampilkan form edit
    public function edit(OutgoingMail $employee)
    {
        $this->formVisible = 'edit';
        // Untuk mengirim data student yang di klik ke komponen lain (komponen edit)
        $this->emit('employeeEdit', $employee);
    }

    // Untuk menampilkan notifikasi dari emit yang dikirim dari komponen edit
    public function employeeEdited()
    {
        session()->flash('message', 'OutgoingMail edited successfully');
        // Tutup form
        $this->closeForm();
    }

    public function confirmOutgoingMailDeletion($id)
    {
        $this->confirmingOutgoingMailDeletion = $id;
    }
}
