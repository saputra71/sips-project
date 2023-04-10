<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateIngoingMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nomor_surat' => 'required|string|max:20|unique:ingoing_mails,nomor_surat,' . $this->ingoing_mail['id'],
            'tgl_surat' => 'required|string|',
            'pengirim' => 'required|string',
            'lampiran' => 'required|string',
            'perihal' => 'required|string',
            'document_id' => 'required|numeric',
            'arsip' => 'file|max:2048',
            'tgl_terima' => 'required|string',
        ];
    }
}
