@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Daftar Genre Buku</h2>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Genre</th>
                        <th scope="col">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $g)
                        <tr>
                            <td>{{ $g['id'] }}</td>
                            <td><span class="fw-bold">{{ $g['name'] }}</span></td>
                            <td>{{ $g['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('authors.index') }}" class="btn btn-outline-primary">
                Lihat Author →
            </a>
        </div>
    </div>
</div>
@endsection
