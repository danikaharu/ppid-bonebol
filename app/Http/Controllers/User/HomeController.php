<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use App\Models\KontakKami;
use App\Models\PengajuanKeberatan;
use App\Models\PermohonanInformasi;
use App\Models\ProfilKantor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infopub_total = InformasiPublik::count();
        $permoinfo_total = PermohonanInformasi::count();
        $pengkeb_total = PengajuanKeberatan::count();

        $profilkantor = ProfilKantor::first();

        return view('fe.home', compact('infopub_total', 'permoinfo_total', 'pengkeb_total', 'profilkantor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function kontakkami(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'pesan' => ['required']
        ]);

        $kontakkami = KontakKami::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan
        ]);

        if ($kontakkami) {
            Alert::success('Berhasil', 'Pesan anda berhasil dikirim');
            return redirect()->route('home');
        } else {
            Alert::success('Berhasil', 'PPesan anda gagal dikirim');
            return redirect()->route('home');
        }
    }
}
