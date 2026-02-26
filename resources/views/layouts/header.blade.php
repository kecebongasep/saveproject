<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-light bg-light px-4">
    <span class="navbar-brand mb-0 h5">
        Sistem Manajemen Perpustakaan
    </span>

    <div class="d-flex align-items-center">
        <span class="me-3">
            {{ auth()->user()->nama }} ({{ auth()->user()->peran }})
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-danger">Logout</button>
        </form>
    </div>
</nav>

</body>
</html>