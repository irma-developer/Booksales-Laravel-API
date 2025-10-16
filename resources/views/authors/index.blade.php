@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-success text-white text-center">
                <h2 class="mb-0">Daftar Author</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Biografi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $a)
                            <tr>
                                <td>{{ $a['id'] }}</td>
                                <td><span class="fw-bold">{{ $a['name'] }}</span></td>
                                <td class="text-start">{{ $a['bio'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-start">
                <a href="{{ route('genres.index') }}" class="btn btn-outline-success">
                    ← Lihat Genre
                </a>
            </div>
            <div class="card-footer text-end">
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                Lihat Buku →
            </a>
        </div>
        </div>
    </div>
@endsection
