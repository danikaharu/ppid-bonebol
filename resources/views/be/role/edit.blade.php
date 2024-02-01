@extends('layouts.be.app')

@section('container')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('admin.role.index') }}" class="btn icon btn-dark"><i data-feather="chevron-left"></i></a>
                <div>
                    <h3 class="m-0">Detail Role</h3>
                </div>
            </div>
        </div>
        <section class="section mt-3">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        @include('be.role.include.form')
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
