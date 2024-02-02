<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Applicant\StoreApplicantRequest;
use App\Models\{Biodata, ProfilKantor, User};
use Illuminate\Support\Facades\{DB, Hash};
use RealRashid\SweetAlert\Facades\Alert;


class PermohonanInformasiController extends Controller
{
    public function index()
    {
        $profilkantor = ProfilKantor::first();
        $total_user = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->count();
        $total_lembaga = Biodata::where('kategori_pemohon', 1)->count();
        $total_perorangan = Biodata::where('kategori_pemohon', 0)->count();

        return view('fe.pemohon-register', compact('profilkantor', 'total_user', 'total_lembaga', 'total_perorangan'));
    }

    public function register($jenis)
    {
        $profilkantor = ProfilKantor::first();
        if ($jenis === 'lembaga') {
            return view('fe.lembaga-register', compact('profilkantor'));
        } elseif ($jenis === 'perorangan') {
            return view('fe.perorangan-register', compact('profilkantor'));
        } else {
            abort(404); // Jenis pemohon tidak valid
        }
    }

    public function store(StoreApplicantRequest $request, $jenis)
    {
        try {
            DB::beginTransaction();

            $attr = $request->validated();

            if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
                $filename = $request->file('file_path')->hashName();

                $directory = $jenis == 'lembaga' ? 'uploads/user/lembaga' : 'uploads/user/perorangan';

                $request->file('file_path')->storeAs($directory, $filename, 'public');

                $attr['file_path'] = $filename;
            }

            $user = User::create([
                'name' => $attr['name'],
                'email' => $attr['email'],
                'password' => Hash::make($attr['password']),
            ]);

            $user->assignRole('user');

            Biodata::create([
                'user_id' => $user->id,
                'kategori_pemohon' => !empty($jenis) && ($jenis == 'lembaga') ? 1 : 0,
                'no_identitas' => $attr['no_identitas'],
                'file_path' => $attr['file_path'],
                'alamat' => $attr['alamat'],
                'no_telp' => $attr['no_telp'],
                'pekerjaan' => $attr['pekerjaan'],
            ]);

            DB::commit();

            Alert::success('Berhasil Registrasi', 'Registrasi Permohonan berhasil. Silahkan login!');
            return redirect()->route('pemohon.register', $jenis);
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Gagal Registrasi', $th->getMessage());
            return redirect()->route('pemohon.register', $jenis);
        }
    }
}
