@extends('be.layouts.app')

@section('container')
    @include('sweetalert::alert')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h3>Pengajuan Keberatan</h3>
                    <p class="text-subtitle text-muted">Buat pengajuan keberatan</a>.</p>
                </div>
                <div class="">
                    <a href="{{ route('admin.pengajuankeberatan.create') }}"
                        class="btn btn-outline-primary block fw-bold px-5">
                        Buat Pengajuan Keberatan
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
                                <th>Rincian Informasi</th>
                                <th>Pesan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Waktu Pengajuan</th>
                                <th>Status</th>
                                <th @role('admin') width="10%" @endrole>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datapis as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->permohonaninformasi->rincian }}</td>
                                    <td>{{ $item->pesan }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->isoFormat('HH:mm') }}
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-warning">Dikirim</span>
                                        @elseif($item->status == 1)
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @include('be.pengajuankeberatan.include.action')
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
