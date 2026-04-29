<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — EasyPark Polije Bondowoso</title>

    @include('layouts.partials.head')
</head>

<body>

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main Wrapper --}}
    <div class="main">

        {{-- Navbar / Topbar --}}
        @include('layouts.partials.navbar')

        {{-- Page Content --}}
        <main class="page">

            {{-- Alert (opsional, tampil jika ada session flash) --}}
            @include('layouts.partials.alert')

            {{-- Konten halaman spesifik --}}
            @yield('content')

        </main>

    </div>

    {{-- Scripts --}}
    @include('layouts.partials.scripts')

    {{-- Stack untuk script tambahan per halaman --}}
    @stack('scripts')

</body>

</html>
