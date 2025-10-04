@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Bahan Baku</h1>
    <a href="{{ route('bahan-baku.create') }}" class="btn btn-primary mb-3">Tambah Bahan Baku</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tgl Kadaluarsa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bahanBakus as $bahan)
            <tr>
                <td>{{ $bahan->nama }}</td>
                <td>{{ $bahan->jumlah }}</td>
                <td>{{ $bahan->satuan }}</td>
                <td>{{ \Carbon\Carbon::parse($bahan->tanggal_kadaluarsa)->format('d M Y') }}</td>
                <td>
                    @if($bahan->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @elseif($bahan->status == 'segera_kadaluarsa')
                        <span class="badge bg-warning text-dark">Segera Kadaluarsa</span>
                    @elseif($bahan->status == 'kadaluarsa')
                        <span class="badge bg-danger">Kadaluarsa</span>
                    @else
                        <span class="badge bg-secondary">Habis</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('bahan-baku.edit', $bahan->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data bahan baku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection