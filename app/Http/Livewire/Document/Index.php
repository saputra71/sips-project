<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;
use App\Models\Document;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class Index extends Component
{
    use WithPagination;

    public $documents, $code, $name, $code_number, $documents_id;
    public $search, $paginate = 10;
    public $confirmingDocumentDeletion = false, $isModal = false;

    protected $listeners = ['delete'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        return view('livewire.document.index', [
            'docs' => $this->search
                ? Document::where('code', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')->latest()
                ->paginate($this->paginate)
                : Document::latest()->paginate($this->paginate)
        ]);
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->isModal = true;
    }
    private function resetCreateForm()
    {
        $this->documents_id = null;
        $this->code = '';
        $this->name = '';
        $this->code_number = '';
    }
    public function store()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'code_number' => 'required',
        ]);

        $documentName = $this->name;

        Document::updateOrCreate(['id' => $this->documents_id], [
            'code' => $this->code,
            'name' => $this->name,
            'code_number' => $this->code_number,
        ]);

        if ($this->documents_id) {
            activity()
                ->causedBy(Auth::user())
                ->log("Telah mengubah dokumen {$documentName}");
        } else {
            activity()
                ->causedBy(Auth::user())
                ->log("Telah menambahkan dokumen {$documentName}");
        }
            
        session()->flash('message', $this->documents_id ? $this->name . ' Diperbarui' : $this->name . ' Ditambahkan');
        $this->isModal = false;
        $this->resetCreateForm();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan',
        ]);
    }
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $this->documents_id = $id;
        $this->code = $document->code;
        $this->name = $document->name;
        $this->code_number = $document->code_number;
        $this->isModal = true;
    }
    public function delete($id)
    {
        $document = Document::find($id);

        $documentName = $document->name;

        $document->delete();

        activity()
            ->causedBy(Auth::user())
            ->log("Telah menghapus dokumen {$documentName}");

        return response()->json(['status' => 'Dokumen Berhasil di hapus!']);
    }

    public function confirmDocumentDeletion($id)
    {
        $this->confirmingDocumentDeletion = $id;
    }
}
