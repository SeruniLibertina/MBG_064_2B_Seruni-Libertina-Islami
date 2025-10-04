@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Konfirmasi Hapus Bahan Baku</h3>
        </div>
        <div class="card-body">
            <p>Anda akan menghapus data berikut:</p>
            <ul>
                <li><strong>Nama Bahan:</strong> {{ $bahan->nama }}</li>
                <li><strong>Kategori:</strong> {{ $bahan->kategori }}</li>
                <li><strong>Status:</strong> {{ $bahan->status }}</li>
            </ul>

            @if ($bahan->status == 'kadaluarsa')
                <p class="text-danger fw-bold">Apakah Anda yakin ingin melanjutkan?</p>
                <form action="{{ route('bahan-baku.destroy', $bahan->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                </form>
            @else
                <p class="text-warning fw-bold">Aksi ditolak. Bahan baku ini tidak dapat dihapus karena statusnya bukan 'Kadaluarsa'.</p>
            @endif

            <a href="{{ route('bahan-baku.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
@endsection