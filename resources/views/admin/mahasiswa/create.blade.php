@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold">Tambah Mahasiswa</h4>
            <p class="text-muted">Buat akun mahasiswa baru untuk sistem</p>
        </div>

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                    @csrf

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Mahasiswa</label>

                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama mahasiswa"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- NIM --}}
                    <div class="mb-3">
                        <label class="form-label">NIM</label>

                        <input type="text"
                            name="nim_nip"
                            class="form-control @error('nim_nip') is-invalid @enderror"
                            placeholder="Masukkan NIM"
                            value="{{ old('nim_nip') }}">

                        @error('nim_nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- NO HP --}}
                    <div class="mb-3">
                        <label class="form-label">No HP</label>

                        <input type="text"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Masukkan nomor HP"
                            value="{{ old('phone') }}">

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- JENIS KELAMIN --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>

                        <select name="gender"
                            class="form-select @error('gender') is-invalid @enderror">

                            <option value="">-- Pilih Jenis Kelamin --</option>

                            <option value="L"
                                {{ old('gender') == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="P"
                                {{ old('gender') == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>

                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- TANGGAL LAHIR --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>

                        <input type="date"
                            name="birth_date"
                            class="form-control @error('birth_date') is-invalid @enderror"
                            value="{{ old('birth_date') }}">

                        @error('birth_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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

                    {{-- PROGRAM STUDI --}}
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>

                        <select name="study_program_id"
                            class="form-select @error('study_program_id') is-invalid @enderror">

                            <option value="">-- Pilih Program Studi --</option>

                            @foreach ($studyPrograms as $studyProgram)
                                <option value="{{ $studyProgram->id }}"
                                    {{ old('study_program_id') == $studyProgram->id ? 'selected' : '' }}>

                                    {{ $studyProgram->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('study_program_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- ALAMAT --}}
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>

                        <textarea name="address"
                            rows="3"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Masukkan alamat mahasiswa">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>

                        <input type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password">

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- STATUS --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            id="is_active"
                            checked>

                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.mahasiswa.index') }}"
                            class="btn btn-secondary">

                            Kembali
                        </a>

                        <button type="submit"
                            class="btn btn-primary">

                            Simpan Mahasiswa
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection