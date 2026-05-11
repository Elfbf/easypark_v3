@extends('layouts.app')

@section('title', 'Info Parkir')
@section('page_title', 'Info Parkir')

@section('content')

<nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
    <a href="{{ url('/') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
    <span style="color:#D4D9E8;">/</span>
    <a href="{{ url('/user') }}" style="color:#8A93AE;text-decoration:none;">User</a>
    <span style="color:#D4D9E8;">/</span>
    <span style="color:#181D35;font-weight:600;">Info Parkir</span>
</nav>

<div class="card" style="border-radius:12px;padding:24px;margin-bottom:16px;">
    <div style="font-size:16px;font-weight:800;color:#181D35;margin-bottom:16px;">Daftar Area Parkir</div>
    @foreach($areas as $area)
    <div style="padding:14px;border:1.5px solid #EBEEF5;border-radius:10px;margin-bottom:10px;">
        <div style="font-weight:700;color:#181D35;margin-bottom:4px;">{{ $area->name }}</div>
        <div style="font-size:12px;color:#8A93AE;">Kode: {{ $area->code }} · Kapasitas: {{ $area->capacity }} slot</div>
        @if($area->description)
        <div style="font-size:12px;color:#5A6378;margin-top:6px;">{{ $area->description }}</div>
        @endif
    </div>
    @endforeach
</div>

<div class="card" style="border-radius:12px;padding:24px;">
    <div style="font-size:16px;font-weight:800;color:#181D35;margin-bottom:12px;">Ketentuan Parkir</div>
    <ul style="font-size:13px;color:#5A6378;line-height:2;padding-left:18px;">
        <li>Kendaraan harus terdaftar dalam sistem EasyPark</li>
        <li>Verifikasi plat nomor wajib dilakukan di kiosk</li>
        <li>Parkir gratis untuk sivitas akademika</li>
        <li>Hubungi petugas jika terjadi kendala</li>
    </ul>
</div>

@endsection