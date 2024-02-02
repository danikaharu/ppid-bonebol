<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Biodata, InformasiPublik, PengajuanKeberatan, PermohonanInformasi, User};
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{File, Hash};
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $infopub = InformasiPublik::count();

            $permoinfo = PermohonanInformasi::count();
            $permoinfo_belum = PermohonanInformasi::where('status', 0)->count();
            $permoinfo_diproses = PermohonanInformasi::where('status', 1)->count();
            $permoinfo_diterima = PermohonanInformasi::where('status', 2)->count();
            $permoinfo_ditolak = PermohonanInformasi::where('status', 3)->count();
            $permoinfo_keberatan = PermohonanInformasi::where('status', 4)->count();

            $pengkeb = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->count();
            $pengkeb_diterima = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('pengajuan_keberatans.status', '=', 1)
                ->count();
            $pengkeb_ditolak = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('pengajuan_keberatans.status', '=', 2)
                ->count();
            $pengkeb_belum = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('pengajuan_keberatans.status', '=', 0)
                ->count();
        } else {
            $infopub = InformasiPublik::where('user_id', auth()->user()->id)->count();

            $permoinfo = PermohonanInformasi::where('petugas_id', auth()->user()->id)->count();
            $permoinfo_belum = 0;
            $permoinfo_diproses = PermohonanInformasi::where('petugas_id', auth()->user()->id)->where('status', 1)->count();
            $permoinfo_diterima = PermohonanInformasi::where('petugas_id', auth()->user()->id)->where('status', 2)->count();
            $permoinfo_ditolak = PermohonanInformasi::where('petugas_id', auth()->user()->id)->where('status', 3)->count();
            $permoinfo_keberatan = PermohonanInformasi::where('petugas_id', auth()->user()->id)->where('status', 4)->count();

            $pengkeb = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('permohonan_informasis.petugas_id', auth()->user()->id)
                ->count();
            $pengkeb_diterima = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('permohonan_informasis.petugas_id', auth()->user()->id)
                ->where('pengajuan_keberatans.status', '=', 1)
                ->count();
            $pengkeb_ditolak = PengajuanKeberatan::join('permohonan_informasis', 'pengajuan_keberatans.permoinfo_id', '=', 'permohonan_informasis.id')
                ->where('permohonan_informasis.petugas_id', auth()->user()->id)
                ->where('pengajuan_keberatans.status', '=', 2)
                ->count();
            $pengkeb_belum = 0;
        }

        return view('be.dashboard', [
            "title" => "Dashboard",
            "infopub" => $infopub,
            "permoinfo" => $permoinfo,
            "pengkeb" => $pengkeb,
            "permoinfo_belum" => $permoinfo_belum,
            "permoinfo_diproses" => $permoinfo_diproses,
            "permoinfo_diterima" => $permoinfo_diterima,
            "permoinfo_ditolak" => $permoinfo_ditolak,
            "permoinfo_keberatan" => $permoinfo_keberatan,
            "pengkeb_diterima" => $pengkeb_diterima,
            "pengkeb_ditolak" => $pengkeb_ditolak,
            "pengkeb_belum" => $pengkeb_belum
        ]);
    }


    public function user()
    {
        if (request()->routeIs('admin.petugas')) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'petugas');
            })->get();
            // dd($users);
            return view('be.user.home', [
                'title' => 'Petugas',
                'users' => $users
            ]);
        } else {
            $users = User::join('biodatas', 'users.id', '=', 'biodatas.user_id')->whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->orderBy('users.created_at', 'desc')->get('users.*');
            // dd($users);
            return view('be.user.home', [
                'title' => 'Pemohon',
                'users' => $users
            ]);
        }
    }

    public function usercreate()
    {
        return view('be.user.create', [
            'title' => 'Tambah Petugas',
        ]);
    }

    public function userstore(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('petugas');

        if ($user) {
            Alert::success('Berhasil', 'Petugas baru berhasil ditambahkan');
            return redirect()->route('admin.petugas');
        } else {
            Alert::error('Gagal', 'Petugas baru gagal ditambahkan');
            return redirect()->route('admin.petugas');
        }
    }

    public function usershow($id)
    {
        $user = User::findorfail($id);

        if (request()->routeIs('admin.petugas.show')) {
            return view('be.user.show', [
                'title' => 'Detail Petugas',
                'user' => $user
            ]);
        } else {
            return view('be.user.show', [
                'title' => 'Detail Pemohon',
                'user' => $user
            ]);
        }
    }

    public function useredit($id)
    {
        $user = User::findorfail($id);

        if (request()->routeIs('admin.petugas.edit')) {
            return view('be.user.edit', [
                'title' => 'Edit Petugas',
                'user' => $user
            ]);
        } else {
            return view('be.user.edit', [
                'title' => 'Edit Pemohon',
                'user' => $user
            ]);
        }
    }

    public function userupdate(Request $request, $id)
    {
        if (request()->routeIs('admin.petugas.update')) {
            $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id]
            ]);

            $user = User::findorfail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            if ($user) {
                Alert::success('Berhasil', 'Data petugas berhasil diperbarui');
                return redirect()->route('admin.petugas');
            } else {
                Alert::error('Gagal', 'Data petugas gagal diperbarui');
                return redirect()->route('admin.petugas');
            }
        } else {
            $request->validate([
                'name' => ['required'],
                'no_identitas' => ['required'],
                'no_telp' => ['required'],
                'pekerjaan' => ['required'],
                'alamat' => ['required'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
                'file' => ['mimes:png,jpg,jpeg', 'max:2080']
            ]);

            $user = User::findorfail($id);
            $biodata = Biodata::where('user_id', $user->id)->first();

            if ($request->has('file')) {
                if (File::exists($request->file_lama)) {
                    File::delete($request->file_lama);
                }

                $file =  $request->file;
                $newfile = time() . $file->getClientOriginalName();

                if ($biodata->kategori_pemohon == 1) {
                    $file->move('uploads/user/lembaga/', $newfile);
                    $biodata_punya = [
                        'no_identitas' => $request->no_identitas,
                        'alamat' => $request->alamat,
                        'no_telp' => $request->no_telp,
                        'pekerjaan' => $request->pekerjaan,
                        'file_path' => 'uploads/user/lembaga/' . $newfile,
                    ];
                } else {
                    $file->move('uploads/user/perorangan/', $newfile);
                    $biodata_punya = [
                        'no_identitas' => $request->no_identitas,
                        'alamat' => $request->alamat,
                        'no_telp' => $request->no_telp,
                        'pekerjaan' => $request->pekerjaan,
                        'file_path' => 'uploads/user/perorangan/' . $newfile,
                    ];
                }

                $user_punya = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];

                $user->update($user_punya);
                $biodata->update($biodata_punya);
            } else {
                $biodata_punya = [
                    'no_identitas' => $request->no_identitas,
                    'alamat' => $request->alamat,
                    'no_telp' => $request->no_telp,
                    'pekerjaan' => $request->pekerjaan,
                ];

                $user_punya = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];

                $user->update($user_punya);
                $biodata->update($biodata_punya);
            }

            Alert::success('Berhasil', 'Data pemohon berhasil diperbarui');
            return redirect()->route('admin.pemohon');
        }
    }

    public function userdestroy($id)
    {
        $user = User::findorfail($id);
        if (request()->routeIs('admin.petugas.destroy')) {
            $user->delete();

            if ($user) {
                Alert::success('Berhasil', 'Data petugas berhasil dihapus');
                return redirect()->route('admin.petugas');
            } else {
                Alert::error('Gagal', 'Data petugas gagal dihapus');
                return redirect()->route('admin.petugas');
            }
        } else {
            if (File::exists($user->biodata->file_path)) {
                File::delete($user->biodata->file_path);
            }
            $biodata = Biodata::where('user_id', $user->id);
            $biodata->delete();
            $user->delete();

            if ($user) {
                Alert::success('Berhasil', 'Data pemohon berhasil dihapus');
                return redirect()->route('admin.pemohon');
            } else {
                Alert::error('Gagal', 'Data pemohon gagal dihapus');
                return redirect()->route('admin.pemohon');
            }
        }
    }

    public function userpassword($id)
    {
        $user = User::findorfail($id);
        return view('be.user.password', [
            'title' => 'Ganti Password',
            'user' => $user
        ]);
    }

    public function userpasswordupdate(Request $request, $id)
    {
        $request->validate([
            'password' => ['required']
        ]);

        $user = User::findorfail($id);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Alert::success('Berhasil', 'Password berhasil diubah');
        return redirect()->back();
    }
}
