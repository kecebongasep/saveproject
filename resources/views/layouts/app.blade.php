<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    <div class="d-flex">
        {{-- SIDEBAR --}}
        <div class="position-fixed top-0 start-0 vh-100 bg-dark text-white"
            style="width:240px">
            @include('layouts.sidebar')
        </div>

        {{-- CONTENT WRAPPER --}}
        <div class="flex-grow-1" style="margin-left:240px">

            {{-- Header --}}
            <div class="sticky-top bg-white shadow-sm">
                @include('layouts.header')
            </div>

            {{-- CONTENT --}}
            <main class="p-4" style="min-height: calc(100vh - 50px)">
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="text-center py-3 border-top">
                © 2026 Sistem Perpustakaan
            </footer>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>