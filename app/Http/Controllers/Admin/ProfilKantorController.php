<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilKantor\UpdateProfilKantorRequest;
use App\Models\ProfilKantor;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $profilkantor = ProfilKantor::first();
        return view('be.profilkantor.index', [
            'title' => 'Profil Kantor',
            'data' => $profilkantor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfilKantor  $profilKantor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfilKantorRequest $request, $id)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        try {
            $attr = $request->validated();

            $profilkantor = ProfilKantor::findorfail($id);
            $profilkantor->update($attr);

            Alert::success('Berhasil', 'Profil berhasil diperbarui!');
            return redirect()->route('admin.profilkantor');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Profil gagal diperbarui!');
            return redirect()->route('admin.profilkantor');
        }
    }
}
