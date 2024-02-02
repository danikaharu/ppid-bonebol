<?php

namespace App\Http\Requests\User\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantRequest extends FormRequest
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
            'alamat' => ['required', 'min:10'],
            'no_telp' => ['required', 'numeric', 'regex:/^\d{10,14}$/'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'same:konfirmasi_password'],
            'no_identitas' => ['required', 'numeric', 'digits:16'],
            'name' => ['required', 'string', 'max:255'],
            'file_path' => ['required', 'mimes:png,jpg,jpeg', 'max:2080'],
        ];
    }

    public function messages()
    {
        return [
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.min' => 'Minimal 10 karakter',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'no_telp.numeric' => 'Nomor telepon harus angka',
            'no_telp.regex' => 'Format tidak valid',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'pekerjaan.max' => 'Maksimal 255 kata',
            'email.required' => 'Emailwajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Maksimal 255 kata',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi ',
            'password.min' => 'Minimal 8 karakter',
            'password.same' => 'Konfirmasi password tidak cocok',
            'no_identitas.required' => 'NIK wajib diisi',
            'no_identitas.numeric' => 'NIK harus angka',
            'no_identitas.digits' => 'Format tidak valid',
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Maksimal 255 kata',
            'file_path.required' => 'File wajib diupload',
            'file_path.mimes' => 'File yang boleh diupload jpg, jpeg, png',
            'file_path.max' => 'Ukuran maksimal 2 MB',
        ];
    }
}
