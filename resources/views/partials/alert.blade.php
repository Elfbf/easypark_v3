<script>
@if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
    });
@endif

@if (session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
    });
@endif

@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: @json($errors->first()),
    });
@endif
</script>