<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreOutgoingMailRequest extends FormRequest
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
            'nomor_surat' => 'string|max:20',
            'tgl_surat' => 'required|string|',
            'pengirim' => 'string',
            'perihal' => 'required|string',
            'menjabat_id' => 'required|numeric',
            'document_id' => 'required|numeric',
            'arsip' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'penerima' => 'required|exists:users,id',
            'lampiran' => 'string|max:20',
            'dasar' => 'string',
            'content' => 'string',
            'user_id' => 'numeric',
        ];
    }
}
