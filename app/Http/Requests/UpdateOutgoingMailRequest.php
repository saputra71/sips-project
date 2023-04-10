<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutgoingMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nomor_surat' => 'required|string|max:50',
            'tgl_surat' => 'required|string|',
            'pengirim' => 'string',
            'perihal' => 'required|string',
            'menjabat_id' => 'required|numeric',
            'document_id' => 'required|numeric',
            'arsip' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'penerima' => 'required|exists:users,id',
            'lampiran' => 'string|max:20',
            'content' => 'string',
            'user_id' => 'numeric',
        ];
    }
}
