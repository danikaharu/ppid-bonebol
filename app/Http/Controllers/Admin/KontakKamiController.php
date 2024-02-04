<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakKami;
use RealRashid\SweetAlert\Facades\Alert;

class KontakKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontakkamis = KontakKami::orderBy('created_at', 'desc')->get();
        return view('be.kotakpesan.index', [
            'title' => 'Kotak Pesan',
            'datas' => $kontakkamis
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KontakKami  $kontakKami
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kontakkami = KontakKami::where('id', $id);
        $kontakkami->delete();

        Alert::success('Berhasil', 'Pesan ini berhasil di hapus');
        return redirect()->route('admin.kotakpesan');
    }
}
