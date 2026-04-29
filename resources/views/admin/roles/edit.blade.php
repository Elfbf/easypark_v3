@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold">Edit Role</h4>
            <p class="text-muted">Perbarui data role</p>
        </div>

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Role</label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $role->name) }}"
                            placeholder="contoh: admin, petugas, mahasiswa">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Update Role
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection