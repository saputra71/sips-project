<?php

namespace App\Http\Livewire\SuratMasuk;

use Livewire\Component;
use App\Models\IngoingMail;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Livewire\WithFileUploads;
use App\Notifications\NewIngoingMailNotification;

class Index extends Component
{
    use WithFileUploads;

    public $ingoingMails, $nomor_surat, $tgl_surat, $pengirim, $lampiran, $perihal, $document_id, $arsip, $tgl_terima, $ingoingMails_id;
    public $isModalOpen = 0, $search, $paginate, $sort;

    public $confirmingOutgoingMailDeletion = false;

    public $listeners = ['delete'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => ''],
    ];

    public function render()
    {
        return view('livewire.surat-masuk.index', [
            'ingoingMail' => $this->search
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

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }
    private function resetCreateForm()
    {
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
        $this->validate([
            'nomor_surat' => 'required',
            'tgl_surat' => 'required',
            'pengirim' => 'required',
            'lampiran' => 'required',
            'perihal' => 'required',
            'document_id' => 'required',
            'arsip' => 'file|max:2048',
            'tgl_terima' => 'required',
        ]);

        $arsip = $this->arsip->storeAs('suratMasuk', $this->arsip->getClientOriginalName(), 'public');


        $ingoingMail = IngoingMail::updateOrCreate(['id' => $this->ingoingMails_id], [
            'nomor_surat' => $this->nomor_surat,
            'tgl_surat' => $this->tgl_surat,
            'pengirim' => $this->pengirim,
            'lampiran' => $this->lampiran,
            'perihal' => $this->perihal,
            'document_id' => $this->document_id,
            'arsip' => $arsip,
            'tgl_terima' => $this->tgl_terima,
        ]);


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Headmaster');
        })->get();

        $authUser = User::find(auth()->user()->id);

        Notification::send($users, new NewIngoingMailNotification($ingoingMail, $authUser));

        session()->flash('message', $this->ingoingMails_id ? 'Surat Masuk Berhasil Diupdate' : 'Surat Masuk Berhasil Ditambahkan');

        $this->closeModalPopover();
        $this->resetCreateForm();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan',
        ]);
    }

    public function edit($id)
    {
        $ingoingMail = IngoingMail::findOrFail($id);
        $this->ingoingMails_id = $id;
        $this->nomor_surat = $ingoingMail->nomor_surat;
        $this->tgl_surat = $ingoingMail->tgl_surat;
        $this->pengirim = $ingoingMail->pengirim;
        $this->lampiran = $ingoingMail->lampiran;
        $this->perihal = $ingoingMail->perihal;
        $this->document_id = $ingoingMail->document_id;
        $this->arsip = $ingoingMail->arsip;
        $this->tgl_terima = $ingoingMail->tgl_terima;

        $this->openModalPopover();
    }

    public function delete($id)
    {
        $ingoingMail = IngoingMail::findOrFail($id);
        $ingoingMail->delete();

        // $this->confirmingOutgoingMailDeletion = false;
        return response()->json(['status' => 'Dokumen Berhasil di hapus!']);
    }
    public function confirmIngoingMailDeletion($id)
    {
        $this->confirmingOutgoingMailDeletion = $id;
    }
}
