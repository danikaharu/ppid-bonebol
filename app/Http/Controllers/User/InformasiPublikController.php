<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{InformasiPublik, ProfilKantor};

class InformasiPublikController extends Controller
{
    public function index()
    {
        $datas = InformasiPublik::orderBy('created_at', 'desc')->get();

        return view('fe.infopub', [
            'title' => 'Informasi Publik',
            'datas' => $datas,
            'profilkantor' => ProfilKantor::first()
        ]);
    }

    public function download(InformasiPublik $informasipublik)
    {
        try {
            $file_path = storage_path('app/public/uploads/infopub/' . $informasipublik->file);

            return response()->download($file_path, $informasipublik->judul . '.pdf', [
                'Content-Type' => 'application/octet-stream',
                'Content-Length' => filesize($file_path),
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
