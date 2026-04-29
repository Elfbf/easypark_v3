<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>

    @include('partials.sidebar')
    @include('partials.navbar')

    <main id="main" class="main">
        @yield('content')
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    {{-- Global Scripts --}}
    @include('partials.scripts')

    {{-- Flash Message --}}
    @include('partials.alert')

    {{-- Page Script --}}
    @yield('scripts')

</body>

</html>
