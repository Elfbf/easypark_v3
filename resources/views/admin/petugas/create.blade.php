@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold">Tambah Petugas</h4>
            <p class="text-muted">Buat akun petugas baru untuk sistem</p>
        </div>

        {{-- Card Form --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.petugas.store') }}" method="POST">
                    @csrf

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>

                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama petugas"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- ID PETUGAS --}}
                    <div class="mb-3">
                        <label class="form-label">ID Petugas</label>

                        <input type="text"
                            name="nim_nip"
                            class="form-control @error('nim_nip') is-invalid @enderror"
                            placeholder="Masukkan ID petugas"
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
                        <a href="{{ route('admin.petugas.index') }}"
                            class="btn btn-secondary">

                            Kembali
                        </a>

                        <button type="submit"
                            class="btn btn-primary">

                            Simpan Petugas
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection