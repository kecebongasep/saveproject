@extends('layouts.app')

@section('title','Detail User')

@section('content')

<div class="card">

    <div class="card-header">
        <h5>Detail User</h5>
    </div>

    <div class="card-body">

        <table class="table">

            <tr>
                <th>Nama</th>
                <td>{{ $user->nama }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>Peran</th>
                <td>{{ $user->peran }}</td>
            </tr>

            <tr>
                <th>Dibuat</th>
                <td>{{ $user->created_at }}</td>
            </tr>

            <tr>
                <th>Terakhir Update</th>
                <td>{{ $user->updated_at }}</td>
            </tr>

        </table>

        <a href="{{ route('user.index') }}"
            class="btn btn-secondary">
            Kembali
        </a>

    </div>
</div>

@endsection