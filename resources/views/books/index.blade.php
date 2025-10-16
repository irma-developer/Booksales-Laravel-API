@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-info text-white text-center">
      <h2 class="mb-0">Daftar Buku</h2>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Harga</th>
            <th>Deskripsi</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($books as $b)
          <tr>
            <td>{{ $b->id }}</td>
            <td class="fw-semibold">{{ $b->title }}</td>
            <td>{{ $b->author->name }}</td>
            <td>{{ $b->genre }}</td>
            <td>{{ $b->published_year }}</td>
            <td>Rp {{ number_format($b->price,0,',','.') }}</td>
            <td class="text-wrap">{{ $b->description }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">Lihat Author →</a>
      <span class="text-muted">Total: {{ $books->count() }} buku</span>
    </div>
  </div>
</div>
@endsection
