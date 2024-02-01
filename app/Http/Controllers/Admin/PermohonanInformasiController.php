<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermohonanInformasi\{StorePermohonanInformasiRequest, UpdatePermohonanInformasiRequest};
use App\Models\PengajuanKeberatan;
use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PermohonanInformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view request')->only('index');
        $this->middleware('permission:create request')->only('create', 'store');
        $this->middleware('permission:edit request')->only('edit', 'update');
        $this->middleware('permission:delete request')->only('destroy');
        $this->middleware('permission:show request')->only('show');
        $this->middleware('permission:approve request')->only('proses', 'terima', 'sendterima', 'batalterima', 'tolak', 'sendtolak');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $datapis = PermohonanInformasi::orderBy('created_at', 'desc');

        if ($user->hasRole('admin')) {
            // Tidak perlu menambahkan filter tambahan untuk admin
        } elseif ($user->hasRole('petugas')) {
            $datapis->where(function ($query) use ($user) {
                $query->where('petugas_id', $user->id)
                    ->orWhereNull('petugas_id');
            });
        } else {
            $datapis->where('user_id', $user->id);
        }

        $datapis = $datapis->get();

        return view('be.permohonaninformasi.home', [
            'title' => 'Permohonan Informasi',
            'datapis' => $datapis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('be.permohonaninformasi.create', [
            'title' => 'Buat Permohonan Informasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermohonanInformasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermohonanInformasiRequest $request)
    {
        $attr = $request->validated();

        if ($attr['mendapat'] == "Soft Copy") {
            $cara = "Online By System";
        } else if ($attr['mendapat'] == "Hard Copy") {
            $cara = "Mengambil Langsung";
        }

        $attr['cara'] = $cara;

        PermohonanInformasi::create($attr);

        Alert::success('Berhasil', 'Permohonan berhasil dibuat.');
        return redirect()->route('admin.permohonaninformasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermohonanInformasi  $permohonanInformasi
     * @return \Illuminate\Http\Response
     */
    public function show(PermohonanInformasi $permohonaninformasi)
    {
        if (auth()->user()->hasRole('user')) {
            if ($permohonaninformasi->user_id == auth()->user()->id) {
                return view('be.permohonaninformasi.show', [
                    'title' => 'Detail Permohonan Informasi',
                    'data' => $permohonaninformasi
                ]);
            }
        } else {
            return view('be.permohonaninformasi.show', [
                'title' => 'Detail Permohonan Informasi',
                'data' => $permohonaninformasi
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermohonanInformasi  $permohonanInformasi
     * @return \Illuminate\Http\Response
     */
    public function edit(PermohonanInformasi $permohonaninformasi)
    {
        if (auth()->user()->hasRole('user')) {
            if ($permohonaninformasi->user_id == auth()->user()->id) {
                return view('be.permohonaninformasi.edit', [
                    'title' => 'Edit Permohonan Informasi',
                    'data' => $permohonaninformasi
                ]);
            }
        } else {
            return view('be.permohonaninformasi.edit', [
                'title' => 'Edit Permohonan Informasi',
                'data' => $permohonaninformasi
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermohonanInformasiRequest  $request
     * @param  \App\Models\PermohonanInformasi  $permohonanInformasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermohonanInformasiRequest $request, PermohonanInformasi $permohonaninformasi)
    {
        $attr =  $request->validated();

        $permohonaninformasi->update($attr);

        Alert::success('Berhasil', 'Permohonan berhasil diperbaruhi.');
        return redirect()->route('admin.permohonaninformasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermohonanInformasi  $permohonanInformasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermohonanInformasi $permohonaninformasi)
    {
        try {
            $path = storage_path('app/public/uploads/permohonan/');

            // if document file exist remove file from directory
            if ($permohonaninformasi->file != null && file_exists($path . $permohonaninformasi->file)) {
                unlink($path . $permohonaninformasi->file);
            }

            PengajuanKeberatan::where('permoinfo_id', $permohonaninformasi->id)->delete();
            $permohonaninformasi->delete();

            Alert::success('Success', 'Permohonan Berhasil di Hapus');

            return redirect()->route('admin.permohonaninformasi.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Permohonan gagal dihapus.');
            return redirect()->route('admin.permohonaninformasi.index');
        }
    }

    public function proses(PermohonanInformasi $permohonaninformasi)
    {
        $permohonaninformasi->update([
            'status' => 1,
            'petugas_id' => auth()->user()->id,
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Detail Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }

    public function tolak(PermohonanInformasi $permohonaninformasi)
    {
        $permohonaninformasi->update([
            'status' => 3,
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Form Pesan Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }

    public function terima(PermohonanInformasi $permohonaninformasi)
    {
        $permohonaninformasi->update([
            'status' => 2,
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Form Pesan Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }

    public function batalterima(PermohonanInformasi $permohonaninformasi)
    {
        $path = storage_path('app/public/uploads/permohonan/');

        // if document file exist remove file from directory
        if ($permohonaninformasi->file != null && file_exists($path . $permohonaninformasi->file)) {
            unlink($path . $permohonaninformasi->file);
        }

        $permohonaninformasi->update([
            'status' => 1,
            'alasan_tolak' => null,
            'pesan' => null,
            'file' => null,
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Form Pesan Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }

    public function sendterima(Request $request, PermohonanInformasi $permohonaninformasi)
    {
        $attr = $request->validate([
            'pesan' => ['required'],
            'file' => ['required'],
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filename = $request->file('file')->hashName();

            $request->file('file')->storeAs('uploads/permohonan', $filename, 'public');

            $attr['file'] = $filename;
        }

        $permohonaninformasi->update([
            'pesan' => $attr['pesan'],
            'file' => $attr['file'],
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Detail Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }

    public function sendtolak(Request $request, PermohonanInformasi $permohonaninformasi)
    {
        $attr = $request->validate([
            'alasan_tolak' => ['required'],
        ]);

        $permohonaninformasi->update([
            'alasan_tolak' => $attr['alasan_tolak'],
        ]);

        return view('be.permohonaninformasi.show', [
            'title' => 'Detail Permohonan Informasi',
            'data' => $permohonaninformasi
        ]);
    }
}
