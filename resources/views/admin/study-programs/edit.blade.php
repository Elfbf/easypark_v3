@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold">Tambah Program Studi</h4>
            <p class="text-muted">Buat program studi baru untuk sistem</p>
        </div>

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.study-programs.store') }}" method="POST">
                    @csrf

                    {{-- JURUSAN --}}
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>

                        <select name="department_id"
                            class="form-select @error('department_id') is-invalid @enderror">

                            <option value="">-- Pilih Jurusan --</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>

                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('department_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- NAMA PRODI --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Program Studi</label>

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
                        <a href="{{ route('admin.study-programs.index') }}"
                            class="btn btn-secondary">

                            Kembali
                        </a>

                        <button type="submit"
                            class="btn btn-primary">

                            Simpan Program Studi
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection