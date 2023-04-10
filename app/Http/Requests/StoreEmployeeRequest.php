<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployeeRequest extends FormRequest
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
            'nip' => 'required|string|max:18|unique:employees,nip',
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required|numeric|digits_between:10,13|unique:employees,phone',
        ];
    }
}
