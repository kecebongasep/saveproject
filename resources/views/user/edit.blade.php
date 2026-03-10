@extends('layouts.app')

@section('title','Edit User')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit User</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('user.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama"
                    value="{{ $user->nama }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                    value="{{ $user->email }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
            </div>

            <div class="mb-3">
                <label>Peran</label>
                <select name="peran" class="form-control">

                    <option value="admin"
                        {{ $user->peran=='admin'?'selected':'' }}>
                        Admin
                    </option>

                    <option value="petugas"
                        {{ $user->peran=='petugas'?'selected':'' }}>
                        Petugas
                    </option>

                    <option value="peminjam"
                        {{ $user->peran=='peminjam'?'selected':'' }}>
                        Peminjam
                    </option>

                </select>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">Update</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection