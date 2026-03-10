<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #111827;
            /* dark modern */
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link i {
            font-size: 18px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #fff;
            padding-left: 20px;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.2);
        }

        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
            font-weight: 500;
        }

        .sidebar h5 {
            color: #fff;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="sidebar p-3">
        <h5 class="mb-4">📚 Perpustakaan</h5>

        <ul class="nav flex-column gap-2">

            {{-- ADMIN --}}
            @if(in_array(auth()->user()->peran, ['admin','petugas']))
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('kategori.index') }}"
                    class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('penulis.index') }}"
                    class="nav-link {{ request()->routeIs('penulis.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Penulis
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('penerbit.index') }}"
                    class="nav-link {{ request()->routeIs('penerbit.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Penerbit
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('buku.index') }}"
                    class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i> Buku
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('peminjaman.index') }}"
                    class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-check"></i> Peminjaman
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.index') }}"
                    class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Kelola User
                </a>
            </li>
            @endif

        </ul>
    </div>

</body>

</html>