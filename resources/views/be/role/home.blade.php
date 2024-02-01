@extends('be.layouts.app')

@section('container')
    @include('sweetalert::alert')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h3>Role</h3>
                    <p class="text-subtitle text-muted">List Data role.</p>
                </div>

                <div class="">
                    <a href="{{ route('admin.role.create') }}" class="btn btn-outline-primary block fw-bold px-5">
                        Tambah Role
                    </a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        @include('be.role.include.action')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
