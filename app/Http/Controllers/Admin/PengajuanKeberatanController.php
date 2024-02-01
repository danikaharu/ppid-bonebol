<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengajuanKeberatan\StorePengajuanKeberatanRequest;
use App\Http\Requests\Admin\PengajuanKeberatan\UpdatePengajuanKeberatanRequest;
use App\Models\{PengajuanKeberatan, PermohonanInformasi};
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanKeberatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $datapis = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->orderBy('pengajuan_keberatans.created_at', 'desc')
                ->get(['pengajuan_keberatans.*']);

            return view('be.pengajuankeberatan.home', [
                'title' => 'Pengajuan Keberatan',
                'datapis' => $datapis
            ]);
        } elseif (auth()->user()->hasRole('petugas')) {
            $datapis = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('permohonan_informasis.petugas_id', auth()->user()->id)
                ->orderBy('pengajuan_keberatans.created_at', 'desc')
                ->get(['pengajuan_keberatans.*']);

            return view('be.pengajuankeberatan.home', [
                'title' => 'Pengajuan Keberatan',
                'datapis' => $datapis
            ]);
        } else {
            $datapis = PengajuanKeberatan::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

            return view('be.pengajuankeberatan.home', [
                'title' => 'Pengajuan Keberatan',
                'datapis' => $datapis
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permoinfo = PermohonanInformasi::where('status', 3)->select('*')->whereNotIn('id', function ($query) {
            $query->select('permoinfo_id')->from('pengajuan_keberatans');
        })->get();

        return view('be.pengajuankeberatan.create', [
            'title' => 'Buat Pengajuan Keberatan',
            'datas' => $permoinfo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePengajuanKeberatanRequest $request)
    {
        $attr = $request->validated();

        PengajuanKeberatan::create($attr);

        Alert::success('Berhasil', 'Pengajuan keberatan berhasil dibuat.');
        return redirect()->route('admin.pengajuankeberatan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengajuanKeberatan  $pengajuanKeberatan
     * @return \Illuminate\Http\Response
     */
    public function show(PengajuanKeberatan $pengajuankeberatan)
    {
        return view('be.pengajuankeberatan.show', [
            'title' => 'Detail Pengajuan Keberatan',
            'data' => $pengajuankeberatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengajuanKeberatan  $pengajuanKeberatan
     * @return \Illuminate\Http\Response
     */
    public function edit(PengajuanKeberatan $pengajuankeberatan)
    {
        if (auth()->user()->hasRole('admin')) {
            $datas = PermohonanInformasi::where('status', 3)
                ->where('id', '!=', $pengajuankeberatan->permoinfo_id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('be.pengajuankeberatan.edit', [
                'title' => 'Edit Pengajuan Keberatan',
                'pengkeb' => $pengajuankeberatan,
                'datas' => $datas
            ]);
        } else {
            if ($pengajuankeberatan->status == 0) {
                $datas = PermohonanInformasi::where('user_id', auth()->user()->id)
                    ->where('status', 3)
                    ->where('id', '!=', $pengajuankeberatan->permoinfo_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return view('be.pengajuankeberatan.edit', [
                    'title' => 'Edit Pengajuan Keberatan',
                    'pengkeb' => $pengajuankeberatan,
                    'datas' => $datas
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengajuanKeberatan  $pengajuanKeberatan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengajuanKeberatanRequest $request, PengajuanKeberatan $pengajuankeberatan)
    {
        $attr = $request->validated();

        $pengajuankeberatan->update($attr);

        Alert::success('Berhasil', 'Pengajuan keberatan berhasil diperbaruhi.');
        return redirect()->route('admin.pengajuankeberatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengajuanKeberatan  $pengajuanKeberatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengajuanKeberatan $pengajuankeberatan)
    {
        $pengajuankeberatan->delete();

        Alert::success('Berhasil', 'Data pengajuan keberatan berhasil dihapus.');
        return redirect()->route('admin.pengajuankeberatan.index');
    }

    public function getPermohonanInformasi($id)
    {
        $perins = PermohonanInformasi::where('id', $id)->orderBy('created_at', 'desc')->get();

        return response()->json($perins);
    }

    public function terima(PengajuanKeberatan $pengajuankeberatan)
    {
        $permohonan = PermohonanInformasi::where('id', $pengajuankeberatan->permoinfo_id);

        $pengajuankeberatan->update([
            'status' => 1,
        ]);

        $permohonan->update([
            'status' => 4,
        ]);

        return view('be.pengajuankeberatan.show', [
            'title' => 'Form Pesan Pengajuan Keberatan',
            'data' => $pengajuankeberatan
        ]);
    }

    public function tolak(PengajuanKeberatan $pengajuankeberatan)
    {
        $pengajuankeberatan->update([
            'status' => 2,
        ]);

        return view('be.pengajuankeberatan.show', [
            'title' => 'Form Penolakan Pengajuan Keberatan',
            'data' => $pengajuankeberatan
        ]);
    }

    public function sendterima(Request $request, PengajuanKeberatan $pengajuankeberatan)
    {
        $attr = $request->validate([
            'pesan' => ['required'],
            'file' => ['required'],
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filename = $request->file('file')->hashName();

            $request->file('file')->storeAs('uploads/keberatan', $filename, 'public');

            $attr['file'] = $filename;
        }

        $pengajuankeberatan->update([
            'pesan' => $attr['pesan'],
            'file' => $attr['file'],
            'status' => 2
        ]);

        Alert::success('Success', 'Data berhasil di kirim');

        return redirect()->route('admin.pengajuankeberatan.index');
    }

    public function sendtolak(Request $request, PengajuanKeberatan $pengajuankeberatan)
    {
        try {
            $request->validate([
                'alasan' => ['required'],
            ]);

            $pengajuankeberatan->update([
                'alasan' => $request->alasan,
                'status' => 2
            ]);

            Alert::success('Success', 'Data berhasil di tolak');

            return redirect()->route('admin.pengajuankeberatan.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Data gagal');

            return redirect()->route('admin.pengajuankeberatan.index');
        }
    }
}
