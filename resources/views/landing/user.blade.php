@extends('layouts.app')

@section('title', 'Halaman User')
@section('page_title', 'Halaman User')

@section('content')

<nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
    <a href="{{ url('/') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
    <span style="color:#D4D9E8;">/</span>
    <span style="color:#181D35;font-weight:600;">User</span>
</nav>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:24px;">

    <div class="card" style="padding:20px;border-radius:12px;">
        <div style="font-size:12px;color:#8A93AE;margin-bottom:6px;">Total Slot</div>
        <div style="font-size:28px;font-weight:800;color:#181D35;">{{ $totalSlot }}</div>
    </div>

    <div class="card" style="padding:20px;border-radius:12px;">
        <div style="font-size:12px;color:#8A93AE;margin-bottom:6px;">Slot Tersedia</div>
        <div style="font-size:28px;font-weight:800;color:#027A48;">{{ $availableSlot }}</div>
    </div>

    <div class="card" style="padding:20px;border-radius:12px;">
        <div style="font-size:12px;color:#8A93AE;margin-bottom:6px;">Slot Terpakai</div>
        <div style="font-size:28px;font-weight:800;color:#DC2626;">{{ $occupiedSlot }}</div>
    </div>

    <div class="card" style="padding:20px;border-radius:12px;">
        <div style="font-size:12px;color:#8A93AE;margin-bottom:6px;">Sedang Parkir</div>
        <div style="font-size:28px;font-weight:800;color:#1A4BAD;">{{ $sedangParkir }}</div>
    </div>

</div>

<div style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="{{ url('/user/cek-slot') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.6rem 1.3rem;border-radius:10px;background:#1A4BAD;color:#fff;text-decoration:none;font-size:13px;font-weight:600;">
        Cek Slot Parkir →
    </a>
    <a href="{{ url('/user/info') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.6rem 1.3rem;border-radius:10px;background:#fff;color:#8A93AE;border:1.5px solid #EBEEF5;text-decoration:none;font-size:13px;">
        Info Parkir
    </a>
</div>

@endsection