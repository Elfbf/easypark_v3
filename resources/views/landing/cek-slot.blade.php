@extends('layouts.app')

@section('title', 'Cek Slot Parkir')
@section('page_title', 'Cek Slot Parkir')

@section('content')

<nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
    <a href="{{ url('/') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
    <span style="color:#D4D9E8;">/</span>
    <a href="{{ url('/user') }}" style="color:#8A93AE;text-decoration:none;">User</a>
    <span style="color:#D4D9E8;">/</span>
    <span style="color:#181D35;font-weight:600;">Cek Slot</span>
</nav>

@foreach($areas as $area)
<div class="card" style="border-radius:12px;margin-bottom:16px;overflow:hidden;border:1.5px solid #EBEEF5;">

    {{-- Header area --}}
    <div style="padding:14px 20px;background:#E8F0FB;border-bottom:1px solid #C0D3F5;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:15px;font-weight:700;color:#181D35;">{{ $area->name }}</div>
            <div style="font-size:12px;color:#3B6FD4;">{{ $area->code }} · Kapasitas {{ $area->capacity }} slot</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:11px;color:#8A93AE;">Tersedia</div>
            <div style="font-size:22px;font-weight:800;color:{{ $area->available_count > 0 ? '#027A48' : '#DC2626' }};">
                {{ $area->available_count }}/{{ $area->parking_slots_count }}
            </div>
        </div>
    </div>

    {{-- Grid slot --}}
    <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(auto-fill,minmax(80px,1fr));gap:10px;">
        @foreach($area->parkingSlots as $slot)
        <div style="
            text-align:center;padding:10px 6px;border-radius:8px;border:1.5px solid;
            {{ $slot->status === 'available'
                ? 'background:#ECFDF3;border-color:#6CE9A6;color:#027A48;'
                : 'background:#FEF2F2;border-color:#FECACA;color:#DC2626;' }}
        ">
            <div style="font-size:13px;font-weight:700;font-family:monospace;">{{ $slot->slot_code }}</div>
            <div style="font-size:10px;margin-top:3px;">{{ $slot->status === 'available' ? 'Kosong' : 'Terisi' }}</div>
        </div>
        @endforeach
    </div>

</div>
@endforeach

<div style="text-align:center;font-size:12px;color:#8A93AE;margin-top:8px;">
    Data diperbarui setiap kali halaman dimuat
</div>

@endsection