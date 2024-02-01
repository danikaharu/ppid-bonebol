<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{InformasiPublik, PengajuanKeberatan, PermohonanInformasi};
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('be.report.index', [
            'title' => 'Laporan'
        ]);
    }

    public function search(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $pilih_laporan = $request->pilih_laporan;
        $status_permoinfo = $request->status_permoinfo;
        $status_pengkeb = $request->status_pengkeb;
        $dari = $request->dari;
        $sampai = $request->sampai;

        if ($pilih_laporan != NULL) {
            if ($pilih_laporan == "Permohonan Informasi") {
                if ($status_permoinfo == "0" && (empty($dari) && empty($sampai))) {
                    $permoinfo = PermohonanInformasi::where('status', 0)->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $permoinfo
                    ]);
                } else if (!empty($status_permoinfo) && empty($dari) && empty($sampai)) {
                    $permoinfo = PermohonanInformasi::where('status', $status_permoinfo)->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $permoinfo
                    ]);
                } else if (!empty($status_permoinfo) && !empty($dari) && !empty($sampai)) {
                    $permoinfo = PermohonanInformasi::where('status', $status_permoinfo)->whereBetween('created_at', [$dari, $sampai])->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $permoinfo
                    ]);
                } else if (empty($status_permoinfo) && !empty($dari) && !empty($sampai)) {
                    $permoinfo = PermohonanInformasi::whereBetween('created_at', [$dari, $sampai])->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $permoinfo
                    ]);
                } else if (empty($status_permoinfo) && empty($dari) && empty($sampai)) {
                    $permoinfo = PermohonanInformasi::orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $permoinfo
                    ]);
                } else {
                    Alert::error('Gagal', 'Silahkan pilih dan lengkapi tanggal terlebih dahulu!');
                    return redirect()->back();
                }
            } else if ($pilih_laporan == "Pengajuan Keberatan") {
                if ($status_pengkeb == "0" && (empty($dari) && empty($sampai))) {
                    $pengkeb = PengajuanKeberatan::where('status', 0)->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $pengkeb
                    ]);
                } else if (!empty($status_pengkeb) && empty($dari) && empty($sampai)) {
                    $pengkeb = PengajuanKeberatan::where('status', $status_pengkeb)->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $pengkeb
                    ]);
                } else if (!empty($status_pengkeb) && !empty($dari) && !empty($sampai)) {
                    $pengkeb = PengajuanKeberatan::where('status', $status_pengkeb)->whereBetween('created_at', [$dari, $sampai])->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $pengkeb
                    ]);
                } else if (empty($status_pengkeb) && !empty($dari) && !empty($sampai)) {
                    $pengkeb = PengajuanKeberatan::whereBetween('created_at', [$dari, $sampai])->orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $pengkeb
                    ]);
                } else if (empty($status_pengkeb) && empty($dari) && empty($sampai)) {
                    $pengkeb = PengajuanKeberatan::orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $pengkeb
                    ]);
                } else {
                    Alert::error('Gagal', 'Silahkan pilih dan lengkapi tanggal terlebih dahulu!');
                    return redirect()->back();
                }
            } else {
                if (empty($dari) && empty($sampai)) {
                    $infopub = InformasiPublik::orderBy('created_at', 'desc')->get();

                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $infopub
                    ]);
                } else if (!empty($dari) && !empty($sampai)) {
                    $infopub = InformasiPublik::whereBetween('created_at', [$dari, $sampai])->orderBy('created_at', 'desc')->get();
                    // dd($infopub);
                    return view('be.report.index', [
                        'title' => 'Laporan ' . $pilih_laporan,
                        'datas' => $infopub
                    ]);
                } else {
                    Alert::error('Gagal', 'Silahkan pilih dan lengkapi tanggal terlebih dahulu!');
                    return redirect()->back();
                }
            }
        } else {
            Alert::error('Gagal', 'Silahkan pilih data terlebih dahulu!');
            return redirect()->back();
        }
    }
}
