<?php

namespace App\Http\Requests\Admin\PengajuanKeberatan;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanKeberatanRequest extends FormRequest
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
            'permoinfo_id' => ['required'],
            'pesan' => ['required'],
            'status' => ['in:0']
        ];
    }
}
