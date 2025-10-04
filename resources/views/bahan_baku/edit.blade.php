@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Update Stok: {{ $bahan->nama }}</h1>

    <form action="{{ route('bahan-baku.update', $bahan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Stok Baru</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $bahan->jumlah }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Stok</button>
        <a href="{{ route('bahan-baku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection