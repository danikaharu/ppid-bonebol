@extends('layouts.be.app')


@section('container')
    <div class="page-title">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex mb-4 gap-3 align-items-center">
                <a href={{ url()->previous() }} class="btn btn-dark icon">
                    <i data-feather="arrow-left" width="20"></i>
                </a>
                <div class="">
                    <h3 class="mb-0">Edit Informasi Publik</h3>
                    <p class="text-subtitle text-muted mb-0">Form Upload Informasi Publik</a></p>
                </div>
            </div>
            <div class="">
            </div>
        </div>
    </div>
    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.infopub.update', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="fw-bold">Klasifikasi Informasi</h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="klasifikasi_id" id="basicSelect" required>
                                                    <option value="" hidden>Pilih Klasifikasi</option>
                                                    @foreach ($klasifikasis as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $data->klasifikasi_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->klasifikasi }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="basicInput" class="fw-bold">Judul</label>
                                                <input type="text"
                                                    class="form-control @error('judul') is-invalid @enderror" name="judul"
                                                    id="basicInput" value="{{ $data->judul }}"">
                                                @error('judul')
                                                    <div class="alert alert-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1"
                                                    class="form-label fw-bold">Ringkasan</label>
                                                <textarea class="form-control @error('ringkasan') is-invalid @enderror" name="ringkasan"
                                                    id="exampleFormControlTextareate1"> {{ $data->ringkasan }}</textarea>
                                                @error('ringkasan')
                                                    <div class="alert alert-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1"
                                                    class="form-label fw-bold">Informasi Terkini</label>
                                                <p class="fw-bold">{{ $data->file }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="fw-bold">Ganti Informasi</p>
                                            <div class="form-file">
                                                <input type="hidden" name="filelama" value={{ $data->file }}>
                                                <input type="file"
                                                    class="form-file-input @error('file') is-invalid @enderror"
                                                    name="file" id="customFile">
                                                @error('file')
                                                    <div class="alert alert-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
