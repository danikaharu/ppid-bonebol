@extends('layouts.be.app')

@section('container')
    @include('sweetalert::alert')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h3>Permohonan Informasi</h3>
                    <p class="text-subtitle text-muted">Buat permohonan informasi</a>.</p>
                </div>
                <div class="">
                    @role('user')
                        <a href="{{ route('admin.permohonaninformasi.create') }}"
                            class="btn btn-outline-primary block fw-bold px-5">
                            Buat Permohonan
                        </a>
                    @endrole
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
                                @role('admin|petugas')
                                    <th>Nama Pemohon</th>
                                    <th>Kategori</th>
                                @endrole
                                <th>Rincian Informasi</th>
                                <th>Tujuan Penggunaan Informasi</th>
                                <th>Tanggal Permohonan</th>
                                @role('admin')
                                    <th>Petugas</th>
                                @endrole
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datapis as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @role('admin|petugas')
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            @if ($item->user->biodata->kategori_pemohon == 1)
                                                Lembaga/Instansi
                                            @else
                                                Perorangan
                                            @endif
                                        </td>
                                    @endrole
                                    <td>{{ $item->rincian }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    @role('admin')
                                        <td>{{ $item->petugas->name }}</td>
                                    @endrole
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-warning">Dikirim</span>
                                        @elseif($item->status == 1)
                                            <span class="badge bg-info">Diproses</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($item->status == 3)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($item->status == 4)
                                            <span class="badge bg-info">Keberatan Diproses</span>
                                        @endif
                                    </td>
                                    <td>
                                        @include('be.permohonaninformasi.include.action')
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
