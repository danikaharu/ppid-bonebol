<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    public function index()
    {
        return view('be.account.index', [
            'title' => 'Pengaturan Akun'
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'name' => ['required'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Alert::success('Berhasil', 'Data anda berhasil diperbarui');
        return redirect()->route('admin.account');
    }

    public function password()
    {
        return view('be.account.password', [
            'title' => 'Pengaturan Password'
        ]);
    }

    public function passwordupdate(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', new MatchOldPassword],
            'password_baru' => ['required'],
            'konfirmasi_password_baru' => ['same:password_baru']
        ]);

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        Alert::success('Berhasil', 'Password anda berhasil diperbarui');
        return redirect()->route('admin.account.password');
    }
}
