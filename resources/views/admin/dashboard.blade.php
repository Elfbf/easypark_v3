@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')

{{-- ── Page Header ── --}}
<div class="page-head">
    <div>
        <div class="page-title">Selamat datang, Admin 👋</div>
        <div class="page-sub">Pantau kondisi parkir kampus hari ini secara real-time</div>
    </div>
    <div class="page-head-actions">
        <button class="btn-outline">Ekspor</button>
        <button class="btn-primary">Tambah Kendaraan</button>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon"></div>
        <div class="stat-card-val">120</div>
        <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
        <div class="stat-card-delta delta-up">↑ 8%</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon"></div>
        <div class="stat-card-val">80</div>
        <div class="stat-card-label">Slot Terisi Sekarang</div>
        <div class="stat-card-delta delta-neu">±2%</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon"></div>
        <div class="stat-card-val">40</div>
        <div class="stat-card-label">Slot Kosong Tersedia</div>
        <div class="stat-card-delta delta-down">↓ 12%</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon"></div>
        <div class="stat-card-val">3</div>
        <div class="stat-card-label">Pelanggaran Tercatat</div>
        <div class="stat-card-delta delta-up">↑ 1</div>
    </div>
</div>

{{-- ── Main Content Grid ── --}}
<div class="content-grid">

    {{-- Tabel Aktivitas --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Masuk / Keluar Terkini</div>
                <div class="card-sub">Diperbarui otomatis setiap 30 detik</div>
            </div>
            <a href="#" class="card-action">Lihat semua</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Pengemudi</th>
                    <th>Zona / Slot</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>W 1234 AB</td>
                    <td>Alief</td>
                    <td>A1 — 01</td>
                    <td>08:30</td>
                    <td><span class="badge badge-in">Masuk</span></td>
                </tr>
                <tr>
                    <td>L 5678 CD</td>
                    <td>Budi</td>
                    <td>A1 — 02</td>
                    <td>09:10</td>
                    <td><span class="badge badge-out">Keluar</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Peta Slot --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Peta Slot — Zona A</div>
                <div class="card-sub">100 slot total · 60 terisi · 40 kosong</div>
            </div>
            <a href="#" class="card-action">Semua zona</a>
        </div>

        <div class="slot-map-wrap">

            <div class="mini-stats">
                <div class="mini-stat">
                    <div class="mini-stat-val">60</div>
                    <div class="mini-stat-label">Terisi</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val">40</div>
                    <div class="mini-stat-label">Kosong</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val">5</div>
                    <div class="mini-stat-label">Blokir</div>
                </div>
            </div>

            <div class="chart-area" id="chartArea"></div>

            <div class="zone-label">Baris 1 — 2</div>
            <div class="slot-row" id="slotRowA"></div>

            <div class="zone-label">Baris 3 — 4</div>
            <div class="slot-row" id="slotRowB"></div>

        </div>
    </div>
</div>

{{-- ── Bottom Grid ── --}}
<div class="bottom-grid">

    {{-- Log --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Log Aktivitas Sistem</div>
        </div>
        <div class="card-body">
            <div class="act-item">
                <div class="act-title">Kendaraan masuk</div>
                <div class="act-meta">W 1234 AB</div>
            </div>
            <div class="act-item">
                <div class="act-title">Kendaraan keluar</div>
                <div class="act-meta">L 5678 CD</div>
            </div>
        </div>
    </div>

    {{-- Zona --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Kapasitas per Zona</div>
        </div>
        <div class="card-body">
            <div class="zone-item">
                <div>Zona A</div>
                <div>60 / 100</div>
            </div>
            <div class="zone-item">
                <div>Zona B</div>
                <div>30 / 100</div>
            </div>
        </div>
    </div>

    {{-- Petugas --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Petugas Berjaga</div>
        </div>
        <div class="card-body">
            <div class="officer-item">
                <div class="off-av">AL</div>
                <div>Alief - Zona A</div>
            </div>
            <div class="officer-item">
                <div class="off-av">BD</div>
                <div>Budi - Zona B</div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const slotsA = [
    {id:'A1', status:'taken'},
    {id:'A2', status:'free'},
    {id:'A3', status:'blocked'},
    {id:'A4', status:'free'}
];

const slotsB = [
    {id:'A5', status:'free'},
    {id:'A6', status:'taken'},
    {id:'A7', status:'free'},
    {id:'A8', status:'blocked'}
];

function buildRow(data, elId) {
    const el = document.getElementById(elId);
    data.forEach(s => {
        const d = document.createElement('div');
        d.className = 'sl ' + s.status;
        d.innerText = s.id;
        el.appendChild(d);
    });
}

buildRow(slotsA, 'slotRowA');
buildRow(slotsB, 'slotRowB');

const hourData = [2,4,6,8,10,6,4,3,5,7,8,6];
const maxV = Math.max(...hourData);
const ca = document.getElementById('chartArea');

hourData.forEach((v, i) => {
    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.height = (v / maxV * 120) + 'px';
    ca.appendChild(bar);
});
</script>
@endpush