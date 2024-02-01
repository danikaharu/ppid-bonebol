<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Klasifikasi\{StoreKlasifikasiRequest, UpdateKlasifikasiRequest};
use App\Models\Klasifikasi;
use RealRashid\SweetAlert\Facades\Alert;

class KlasifikasiController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view classification')->only('index');
        $this->middleware('permission:create classification')->only('create', 'store');
        $this->middleware('permission:edit classification')->only('edit', 'update');
        $this->middleware('permission:delete classification')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $klasifikasis = Klasifikasi::orderBy('created_at', 'desc')->get();
        return view('be.klasifikasi.home', [
            'title' => 'Klasifkasi',
            'klasifikasis' => $klasifikasis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('be.klasifikasi.create', [
            'title' => 'Tambah Klasifikasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKlasifikasiRequest $request)
    {
        $attr = $request->validated();

        $klasifikasi = Klasifikasi::create($attr);

        if ($klasifikasi) {
            Alert::success('Berhasil', 'Klasifikasi berhasil di tambahkan');
            return redirect()->route('admin.klasifikasi.index');
        } else {
            Alert::error('Gagal', 'Klasifikasi gagal di tambahkan');
            return redirect()->route('admin.klasifikasi.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klasifikasi  $klasifikasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Klasifikasi $klasifikasi)
    {
        return view('be.klasifikasi.edit', [
            'title' => 'Edit Klasifikasi',
            'data' => $klasifikasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Klasifikasi  $klasifikasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKlasifikasiRequest $request, Klasifikasi $klasifikasi)
    {
        $attr = $request->validated();

        $klasifikasi->update($attr);

        if ($klasifikasi) {
            Alert::success('Berhasil', 'Klasifikasi berhasil di perbarui');
            return redirect()->route('admin.klasifikasi.index');
        } else {
            Alert::error('Gagal', 'Klasifikasi gagal di perbarui');
            return redirect()->route('admin.klasifikasi.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klasifikasi  $klasifikasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klasifikasi $klasifikasi)
    {
        $klasifikasi->delete();

        Alert::success('Berhasil', 'Klasifikasi berhasil di hapus');

        return redirect()->route('admin.klasifikasi.index');
    }
}
