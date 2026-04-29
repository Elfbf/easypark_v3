@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Judul --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Daftar Jurusan</h4>

            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Jurusan
            </a>
        </div>

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">

                @if ($departments->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Nama Jurusan</th>
                                    <th style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($departments as $index => $department)
                                    <tr>

                                        <td>
                                            {{ $departments->firstItem() + $index }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $department->name }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2">

                                                {{-- EDIT --}}
                                                <a href="{{ route('admin.departments.edit', $department->id) }}"
                                                    class="btn btn-sm btn-warning">

                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                {{-- DELETE --}}
                                                <form action="{{ route('admin.departments.destroy', $department->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">

                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-4">
                        {{ $departments->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-info-circle fs-3"></i>

                        <p class="mt-3 mb-0">
                            Belum ada data jurusan.
                        </p>
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
