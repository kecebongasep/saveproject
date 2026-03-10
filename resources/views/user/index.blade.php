@extends('layouts.app')

@section('title','Kelola User')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Kelola User</h5>

        <a href="{{ route('user.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($user as $u)

                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->peran }}</td>

                    <td>
                        <a href="{{ route('user.show',$u->id) }}"
                            class="btn btn-sm btn-info text-white">
                            Detail
                        </a>

                        <a href="{{ route('user.edit',$u->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('user.destroy',$u->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>

                        </form>

                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection