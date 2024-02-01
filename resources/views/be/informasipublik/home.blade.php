@extends('be.layouts.app')

@section('container')
    @include('sweetalert::alert')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h3>Informasi Publik</h3>
                    <p class="text-subtitle text-muted">Upload Informasi dan Dokumentasi</a>.</p>
                </div>
                <div class="">
                    @can('create information')
                        <a href="{{ route('admin.infopub.create') }}" class="btn btn-outline-primary block fw-bold px-5">
                            Tambah Informasi
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Informasi dan Dokumentasi
                </div>
                <div class="card-body">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th width = "3%">No</th>
                                <th width = "10%">Informasi</th>
                                <th width = "25%">Judul</th>
                                <th width = "20%">Ringkasan</th>
                                <th width = "15%">Waktu</th>
                                <th width = "5%">Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($informasis as $informasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $informasi->klasifikasi->klasifikasi }}</td>
                                    <td>{{ $informasi->judul }}</td>
                                    <td>{{ $informasi->ringkasan }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $informasi->created_at)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td><span
                                            class="badge bg-danger">{{ $ext = pathinfo(storage_path() . $informasi->file, PATHINFO_EXTENSION) }}</span>
                                    </td>
                                    <td>
                                        @include('be.informasipublik.include.action')
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
