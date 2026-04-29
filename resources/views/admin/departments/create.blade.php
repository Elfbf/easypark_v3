@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold">Tambah Jurusan</h4>
            <p class="text-muted">Buat jurusan baru untuk sistem</p>
        </div>

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>

                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="contoh: Teknik Informatika"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.departments.index') }}"
                            class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan Jurusan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection