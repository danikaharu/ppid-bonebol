@extends('layouts.fe.app')

@section('content')
    @include('sweetalert::alert')
    <section class="section mt-5">
        <div class="container">

            <h6 class="xs-font mb-0 text-center">PPID Bone Bolango</h6>
            <h3 class="section-title mb-4 text-center">Permohonan Informasi Publik</h3>
            <div class="my-5">
                <h5 class="text-center">PILIH KATEGORI PEMOHON</h5>
                <hr>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <a href="{{ route('pemohon.register', 'lembaga') }}">
                            <div class="card shadow-sm bg-primary border-0">
                                <div class="card-body text-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <h1 class="mb-1"><i class="ti-write"></i></h1>
                                        <h3 class="m-0">LEMBAGA/INSTANSI</h3>
                                        <p class="mt-3 mb-0 text-light">Registrasi akun sebagai lembaga atau instansi.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="{{ route('pemohon.register', 'perorangan') }}">
                            <div class="card shadow-sm bg-primary border-0">
                                <div class="card-body text-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <h1 class="mb-1"><i class="ti-write"></i></h1>
                                        <h3 class="m-0">PERORANGAN</h3>
                                        <p class="mt-3 mb-0 text-light">Registrasi akun perorangan.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-lg border border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 class="m-0">
                                    <i class="ti-user"></i>
                                </h1>
                                <div class="ml-3">
                                    <p class="m-0 font-weight-bold text-primary">
                                        Total Pengguna
                                    </p>
                                    <h4 class="m-0">{{ $total_user ?? '' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-lg border border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 class="m-0">
                                    <i class="ti-user"></i>
                                </h1>
                                <div class="ml-3">
                                    <p class="m-0 font-weight-bold text-primary">
                                        Lembaga/Instansi
                                    </p>
                                    <h4 class="m-0">{{ $total_lembaga ?? '' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-lg border border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 class="m-0">
                                    <i class="ti-user"></i>
                                </h1>
                                <div class="ml-3">
                                    <p class="m-0 font-weight-bold text-primary">
                                        Perorangan
                                    </p>
                                    <h4 class="m-0">{{ $total_perorangan ?? '' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
