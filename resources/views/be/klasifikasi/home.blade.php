@extends('layouts.be.app')

@section('container')
    @include('sweetalert::alert')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h3>Master Klasifikasi</h3>
                    <p class="text-subtitle text-muted">Master Data - Klasifikasi.</p>
                </div>
                @can('create classification')
                    <a href="{{ route('admin.klasifikasi.create') }}" class="btn btn-outline-primary block fw-bold px-5">Tambah
                        Klasifikasi</a>
                @endcan
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Klasifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($klasifikasis as $klasifikasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $klasifikasi->klasifikasi }}</td>
                                    <td>
                                        @include('be.klasifikasi.include.action')
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
