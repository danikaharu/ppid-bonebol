<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{InformasiPublik, Klasifikasi};
use App\Http\Requests\Admin\InformasiPublik\{StoreInformasiPublikRequest, UpdateInformasiPublikRequest};
use RealRashid\SweetAlert\Facades\Alert;

class InformasiPublikController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view information')->only('index');
        $this->middleware('permission:create information')->only('create', 'store');
        $this->middleware('permission:edit information')->only('edit', 'update');
        $this->middleware('permission:delete information')->only('destroy');
        $this->middleware('permission:show information')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $informasis = InformasiPublik::orderBy('created_at', 'desc');

        if ($user->hasRole('admin')) {
            // Tidak perlu menambahkan filter tambahan untuk admin
        } else {
            $informasis->where('user_id', $user->id);
        }

        $informasis = $informasis->get();

        return view('be.informasipublik.home', [
            "title" => "Informasi Publik",
            "informasis" => $informasis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('be.informasipublik.create', [
            "title" => "Informasi Publik",
            "klasifikasis" => Klasifikasi::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInformasiPublikRequest $request)
    {
        $attr = $request->validated();

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filename = $request->file('file')->hashName();
            $filesize = $request->file('file')->getSize();

            $request->file('file')->storeAs('uploads/infopub', $filename, 'public');

            $attr['file'] = $filename;
            $attr['filesize'] = $filesize;
        }

        InformasiPublik::create($attr);

        Alert::success('Success', 'Informasi Berhasil di Upload');

        return redirect()->route('admin.infopub.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InformasiPublik  $informasiPublik
     * @return \Illuminate\Http\Response
     */
    public function show(InformasiPublik $infopub)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('be.informasipublik.view', [
                "title" => "Informasi Publik",
                "data" => $infopub
            ]);
        } else {
            if ($infopub->user_id == auth()->user()->id) {
                return view('be.informasipublik.view', [
                    "title" => "Informasi Publik",
                    "data" => $infopub
                ]);
            } else {
                Alert::error('Maaf', 'Anda tidak mempunyai akses ke halaman ini.');
                return redirect()->route('admin.infopub.index');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InformasiPublik  $informasiPublik
     * @return \Illuminate\Http\Response
     */
    public function edit(InformasiPublik $infopub)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('be.informasipublik.edit', [
                "title" => "Ubah Data Informasi Publik",
                "data" => $infopub,
                "klasifikasis" => Klasifikasi::get()
            ]);
        } else {
            if ($infopub->user_id == auth()->user()->id) {
                return view('be.informasipublik.edit', [
                    "title" => "Ubah Data Informasi Publik",
                    "data" => $infopub,
                    "klasifikasis" => Klasifikasi::get()
                ]);
            } else {
                Alert::error('Maaf', 'Anda tidak mempunyai akses ke halaman ini.');
                return redirect()->route('admin.infopub.index');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InformasiPublik  $informasiPublik
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInformasiPublikRequest $request, InformasiPublik $infopub)
    {
        $attr = $request->validated();

        if ($request->file('file') && $request->file('file')->isValid()) {

            $path = storage_path('app/public/uploads/infopub/');
            $filename = $request->file('file')->hashName();
            $filesize = $request->file('file')->getSize();

            // delete old file from storage
            if ($infopub->file != null && file_exists($path . $infopub->file)) {
                unlink($path . $infopub->file);
            }

            $request->file('file')->storeAs('upload/infopub/', $filename, 'public');

            $attr['file'] = $filename;
            $attr['filesize'] = $filesize;
        }

        $infopub->update($attr);

        return redirect()->route('admin.infopub.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InformasiPublik  $informasiPublik
     * @return \Illuminate\Http\Response
     */
    public function destroy(InformasiPublik $infopub)
    {
        $pathFile = storage_path('app/public/uploads/infopub/');

        // if document file exist remove file from directory
        if ($infopub->file != null && file_exists($pathFile . $infopub->file)) {
            unlink($pathFile . $infopub->file);
        }

        $infopub->delete();

        Alert::success('Success', 'Informasi Berhasil di Hapus');

        return redirect()->route('admin.infopub.index');
    }
}
