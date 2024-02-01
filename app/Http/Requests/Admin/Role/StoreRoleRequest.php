<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|min:2|max:30|unique:roles,name',
            'permissions' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama minimal 2 kata',
            'name.max' => 'Nama maksimal 30 kata',
            'name.unique' => 'Nama role sudah ada',
            'permissions.required' => 'Akses role wajib diisi',
        ];
    }
}
