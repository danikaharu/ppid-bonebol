<?php

namespace App\Http\Requests\Admin\ProfilKantor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilKantorRequest extends FormRequest
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
            'tentang' => ['required'],
            'alamat' => ['required'],
            'telepon' => ['required'],
            'email' => ['required', 'email'],
            'fb' => ['required'],
            'tw' => ['required'],
            'ig' => ['required']
        ];
    }
}
