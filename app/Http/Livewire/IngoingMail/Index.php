<?php

namespace App\Http\Livewire\IngoingMail;

use Livewire\Component;
use App\Models\Document;
use App\Models\IngoingMail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Termwind\Components\Dd;

class Index extends Component
{
    // Gunakan ini agar menggunakan pagination milik livewire
    use WithPagination, WithFileUploads;

    // db attr
    public $nomor_surat, $tgl_surat, $tgl_terima, $pengirim, $perihal, $arsip, $document_id, $lampiran, $ingoingMailId;

    public $paginate = 10, $search, $formVisible = false, $sort;
    public $isModal = false, $editModal = false;

    // Untuk mengupdate 'search' yang ada di url
    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => ''],
    ];

    // Membuat listener untuk emit yang dibuat di komponen lain
    protected $listeners = ['destroy'];

    public function render()
    {
        return view('livewire.ingoing-mail.index', [
            'ingoingMails' => $this->search
                ? IngoingMail::where('nomor_surat', 'like', '%' . $this->search . '%')
                ->orWhere('pengirim', 'like', '%' . $this->search . '%')
                ->orWhere('perihal', 'like', '%' . $this->search . '%')
                ->orWhere('tgl_surat', 'like', '%' . $this->search . '%')
                ->orWhere('tgl_terima', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate($this->paginate)
                : IngoingMail::where('document_id', 'like', '%' . $this->sort . '%')
                ->latest()
                ->paginate($this->paginate),
            'documents' => Document::all(),
        ]);
    }

    // Untuk menampilkan form tambah
    public function create()
    {
        $this->resetForm();
        $this->isModal = true;
    }

    public function resetForm()
    {
        $this->ingoingMailId = null;
        $this->nomor_surat = '';
        $this->tgl_surat = '';
        $this->pengirim = '';
        $this->lampiran = '';
        $this->perihal = '';
        $this->document_id = '';
        $this->arsip = '';
        $this->tgl_terima = '';
    }

    public function store()
    {
        // dd($this->arsip);
        $this->validate([
            'nomor_surat' => 'required|string|unique:ingoing_mails,nomor_surat,' . $this->ingoingMailId,
            'tgl_surat' => 'required|string',
            'pengirim' => 'required|string',
            'lampiran' => 'required|string',
            'perihal' => 'required|string',
            'document_id' => 'required|numeric|exists:documents,id',
            'tgl_terima' => 'required|string',
            'arsip' => 'required|file|mimes:pdf|max:20000',
        ]);

        IngoingMail::Create([
            'nomor_surat' => $this->nomor_surat,
            'tgl_surat' => $this->tgl_surat,
            'pengirim' => $this->pengirim,
            'lampiran' => $this->lampiran,
            'perihal' => $this->perihal,
            'document_id' => $this->document_id,
            'tgl_terima' => $this->tgl_terima,
            'arsip' => $this->arsip->store('suratMasuk', 'public'),
        ]);


        session()->flash('message', $this->ingoingMailId ? $this->nomor_surat . ' Diperbarui' : $this->nomor_surat . ' Ditambahkan');
        $this->isModal = false;
        $this->resetForm();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan',
        ]);
    }

    // Untuk menghapus data
    public function destroy(IngoingMail $ingoingMail)
    {
        $ingoingMail->delete();

        if ($ingoingMail->arsip) {
            Storage::disk('public')->delete($ingoingMail->arsip);
        }

        // Untuk memberi notifikasi
        session()->flash('message', 'IngoingMail deleted successfully');
    }

    // Untuk menampilkan form edit
    public function edit($id)
    {
        $ingoingMail = IngoingMail::findOrFail($id);
        $this->ingoingMailId = $id;
        $this->nomor_surat = $ingoingMail->nomor_surat;
        $this->tgl_surat = $ingoingMail->tgl_surat;
        $this->pengirim = $ingoingMail->pengirim;
        $this->lampiran = $ingoingMail->lampiran;
        $this->perihal = $ingoingMail->perihal;
        $this->document_id = $ingoingMail->document_id;
        $this->arsip = $ingoingMail->arsip;
        $this->tgl_terima = $ingoingMail->tgl_terima;
        $this->editModal = true;
    }

    public function update()
    {
        // Validasi
        $this->validate([
            'nomor_surat' => 'required|string|unique:ingoing_mails,nomor_surat,' . $this->ingoingMailId,
            'tgl_surat' => 'required|string',
            'pengirim' => 'required|string',
            'lampiran' => 'required|string',
            'perihal' => 'required|string',
            'document_id' => 'required|numeric',
            'tgl_terima' => 'required|string',
        ]);

        if ($this->ingoingMailId) {
            $ingoingMail = IngoingMail::find($this->ingoingMailId);
            $ingoingMail->update([
                'nomor_surat' => $this->nomor_surat,
                'tgl_surat' => $this->tgl_surat,
                'pengirim' => $this->pengirim,
                'lampiran' => $this->lampiran,
                'perihal' => $this->perihal,
                'document_id' => $this->document_id,
                'tgl_terima' => $this->tgl_terima,
            ]);

            $this->editModal = false;
            $this->resetForm();

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Data berhasil diperbarui',
            ]);
        }
    }

    public function disposisi(IngoingMail $ingoingMail)
    {
        $this->formVisible = 'disposisi';
        // Untuk mengirim data student yang di klik ke komponen lain (komponen edit)
        $this->emit('ingoingMailEdit', $ingoingMail);
    }

    public function closeModal()
    {
        $this->isModal = false;
        $this->editModal = false;   
        $this->resetForm();
    }
}
