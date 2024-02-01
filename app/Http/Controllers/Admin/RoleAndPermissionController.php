<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\{StoreRoleRequest, UpdateRoleRequest};
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();

        return view('be.role.home', [
            "title" => "Role dan Hak Akses",
            "roles" => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('be.role.create', [
            "title" => "Buat Role"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.role.index')
            ->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('be.role.edit', [
            "title" => "Edit Role",
            "role" => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request,  Role $role)
    {
        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.role.index')
            ->with('success', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        // if any user where role.id = $id
        if ($role->users_count < 1) {
            $role->delete();

            return redirect()
                ->route('admin.role.index')
                ->with('success', __('Data berhasil dihapus.'));
        } else {
            return redirect()
                ->route('admin.role.index')
                ->with('error', __('Tidak bisa hapus role.'));
        }

        return redirect()->route('admin.role.index');
    }
}
