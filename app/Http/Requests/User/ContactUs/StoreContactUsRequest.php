<?php

namespace App\Http\Requests\User\ContactUs;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactUsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'pesan' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.max' => 'Maksimal 255 karakter',
            'pesan.required' => 'Pesan wajib diisi',
        ];
    }
}
