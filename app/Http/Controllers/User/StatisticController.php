<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{InformasiPublik, PengajuanKeberatan, PermohonanInformasi, ProfilKantor};
use Carbon\Carbon;

class StatisticController extends Controller
{
    public function index()
    {
        $infopub_total = InformasiPublik::count();
        $permoinfo_total = PermohonanInformasi::count();
        $pengkeb_total = PengajuanKeberatan::count();
        $permoinfo_selesai_total = PermohonanInformasi::where('status', 2)->count();

        $infopub = InformasiPublik::join('klasifikasis', 'informasi_publiks.klasifikasi_id', '=', 'klasifikasis.id')
            ->selectRaw('COUNT(*) as count, klasifikasis.klasifikasi')
            ->groupBy('klasifikasis.klasifikasi')
            ->get();

        $permoinfo_belum = PermohonanInformasi::where('status', 0)->count();
        $permoinfo_diproses = PermohonanInformasi::where('status', 1)->count();
        $permoinfo_diberikan = PermohonanInformasi::where('status', 2)->count();
        $permoinfo_ditolak = PermohonanInformasi::where('status', 3)->count();

        $permoinfo = PermohonanInformasi::join('users', 'permohonan_informasis.user_id', '=', 'users.id')
            ->whereMonth('permohonan_informasis.created_at', Carbon::now()->month)
            ->selectRaw('COUNT(*) as count, users.name')
            ->groupBy('users.name')
            ->take(10)
            ->get();

        $pengkeb = PengajuanKeberatan::join('users', 'pengajuan_keberatans.user_id', '=', 'users.id')
            ->whereMonth('pengajuan_keberatans.created_at', Carbon::now()->month)
            ->selectRaw('COUNT(*) as count, users.name')
            ->groupBy('users.name')
            ->take(10)
            ->get();

        $profilkantor = ProfilKantor::first();

        return view('fe.statistik', compact('profilkantor', 'infopub', 'permoinfo', 'pengkeb', 'infopub_total', 'permoinfo_total', 'pengkeb_total', 'permoinfo_selesai_total', 'permoinfo_belum', 'permoinfo_diproses', 'permoinfo_diberikan', 'permoinfo_ditolak'));
    }
}
