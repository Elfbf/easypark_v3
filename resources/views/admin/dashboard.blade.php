@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@php
    // Dummy data (sementara)
    $totalMahasiswa = 120;
    $totalKendaraan = 85;
    $totalParkirMahasiswa = 40;
    $totalParkirTamu = 12;

    $parkirHariIni = [
        [
            'tipe' => 'Mahasiswa',
            'name' => 'Alief Chandra',
            'plat' => 'P 1234 ABC',
            'tipe_kendaraan' => 'motor',
            'entry_time' => now()
        ],
        [
            'tipe' => 'Tamu',
            'name' => 'Budi Santoso',
            'plat' => 'L 5678 XYZ',
            'tipe_kendaraan' => 'mobil',
            'entry_time' => now()->subMinutes(30)
        ],
        [
            'tipe' => 'Mahasiswa',
            'name' => 'Siti Aminah',
            'plat' => 'N 9999 AA',
            'tipe_kendaraan' => 'motor',
            'entry_time' => now()->subHours(1)
        ],
    ];
@endphp

<div class="pagetitle">
    <h1>Dashboard</h1>
</div>

<section class="section dashboard">
    <div class="row">

        {{-- Dashboard Cards --}}
        <div class="col-lg-12">
            <div class="row">

                {{-- Mahasiswa --}}
                <div class="col-xxl-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Mahasiswa</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-primary text-white p-3 rounded-circle">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalMahasiswa }}</h6>
                                    <span class="text-muted small">Total Mahasiswa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kendaraan --}}
                <div class="col-xxl-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Kendaraan</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-success text-white p-3 rounded-circle">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalKendaraan }}</h6>
                                    <span class="text-muted small">Total Kendaraan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Parkir Mahasiswa --}}
                <div class="col-xxl-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Parkir Mahasiswa</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-warning text-white p-3 rounded-circle">
                                    <i class="bi bi-car-front-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalParkirMahasiswa }}</h6>
                                    <span class="text-muted small">Transaksi Parkir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Parkir Tamu --}}
                <div class="col-xxl-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Parkir Tamu</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-danger text-white p-3 rounded-circle">
                                    <i class="bi bi-car-front-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalParkirTamu }}</h6>
                                    <span class="text-muted small">Transaksi Tamu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Monitoring Parkir --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Monitoring Parkir Hari Ini</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light small text-uppercase">
                                <tr>
                                    <th>Tipe</th>
                                    <th>Nama</th>
                                    <th>Plat</th>
                                    <th>Kendaraan</th>
                                    <th>Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parkirHariIni as $data)

                                    @php
                                        $isMotor = strtolower($data['tipe_kendaraan']) === 'motor';
                                        $icon = $isMotor ? 'bi-bicycle' : 'bi-car-front-fill';
                                        $badge = $data['tipe'] === 'Mahasiswa' ? 'primary' : 'danger';
                                    @endphp

                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $badge }}">
                                                {{ $data['tipe'] }}
                                            </span>
                                        </td>

                                        <td class="fw-semibold">{{ $data['name'] }}</td>

                                        <td>
                                            <span class="badge bg-dark">
                                                {{ $data['plat'] }}
                                            </span>
                                        </td>

                                        <td>
                                            <i class="bi {{ $icon }}"></i>
                                            {{ ucfirst($data['tipe_kendaraan']) }}
                                        </td>

                                        <td class="text-success">
                                            {{ \Carbon\Carbon::parse($data['entry_time'])->format('H:i') }}
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection