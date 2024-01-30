<?php

namespace App\Http\Requests\Admin\InformasiPublik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformasiPublikRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['exists:App\Models\User,id'],
            'klasifikasi_id' => ['required', 'exists:App\Models\Klasifikasi,id'],
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:255'],
            'file' => ['sometimes', 'required', 'file', 'max:20000', 'mimes:pdf'],
            'filesize' => ['min:1']
        ];
    }
}
