<?php

namespace App\Http\Requests\Admin\PermohonanInformasi;

use Illuminate\Foundation\Http\FormRequest;

class StorePermohonanInformasiRequest extends FormRequest
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
     * Store user_id in database 
     *
     * 
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id,
            'status' => 0
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
            'rincian' => ['required'],
            'tujuan' => ['required'],
            'mendapat' => ['required'],
            'cara' => ['min:3'],
            'status' => ['in:0']
        ];
    }
}
