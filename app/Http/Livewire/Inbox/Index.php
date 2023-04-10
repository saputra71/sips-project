<?php

namespace App\Http\Livewire\Inbox;

use Livewire\Component;
use App\Models\OutgoingMail;
use Livewire\WithPagination;
use App\Models\Document;

class Index extends Component
{
    use WithPagination;

    public $paginate = 10, $search, $sort;

    public function render()
    {
        return view('livewire.inbox.index', [
            'outgoingMails' => $this->search
                ? OutgoingMail::join('users', 'users.id', '=', 'outgoing_mails.pengirim')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('outgoing_mails.nomor_surat', 'like', '%' . $this->search . '%')
                ->orWhere('outgoing_mails.perihal', 'like', '%' . $this->search . '%')
                ->orWhere('outgoing_mails.tgl_surat', 'like', '%' . $this->search . '%')
                ->latest('outgoing_mails.created_at')
                ->paginate($this->paginate)
                : OutgoingMail::where('document_id', 'like', '%' . $this->sort . '%')
                ->latest()
                ->paginate($this->paginate),
            'documents' => Document::all(),
        ]);

        // SELECT * FROM outgoing_mails
        // JOIN users ON users.id = outgoing_mails.pengirim
        // WHERE users.name = "Riska"

    }
    public function refreshContent()
    {
        $this->search = '';
        $this->sort = '';
    }
}
