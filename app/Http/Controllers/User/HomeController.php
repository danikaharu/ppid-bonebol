<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactUs\StoreContactUsRequest;
use App\Models\{InformasiPublik, KontakKami, PengajuanKeberatan, PermohonanInformasi, ProfilKantor};
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
    public function kontakkami(StoreContactUsRequest $request)
    {
        try {
            $attr = $request->validated();

            KontakKami::create($attr);

            Alert::success('Berhasil', 'Pesan anda berhasil dikirim');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            Alert::success('Berhasil', 'Pesan anda gagal dikirim');
            return redirect()->route('home');
        }
    }
}
