@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Bahan Baku</h1>
        <a href="{{ route('bahan-baku.create') }}" class="btn btn-primary">
            Tambah Bahan Baku
        </a>
    </div>
    
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Bahan</th>
                        <th>Jumlah</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bahanBakus as $bahan)
                    <tr>
                        <td>
                            <strong>{{ $bahan->nama }}</strong><br>
                            <small class="text-muted">{{ $bahan->kategori }}</small>
                        </td>
                        <td>{{ $bahan->jumlah }} {{ $bahan->satuan }}</td>
                        <td>{{ \Carbon\Carbon::parse($bahan->tanggal_kadaluarsa)->format('d M Y') }}</td>
                        <td>
                            @if($bahan->status == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif($bahan->status == 'segera_kadaluarsa')
                                <span class="badge bg-warning">Segera Kadaluarsa</span>
                            @elseif($bahan->status == 'kadaluarsa')
                                <span class="badge bg-danger">Kadaluarsa</span>
                            @else
                                <span class="badge bg-secondary">Habis</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('bahan-baku.edit', $bahan->id) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>
                            <a href="{{ route('bahan-baku.confirm-delete', $bahan->id) }}" class="btn btn-sm btn-danger">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada data bahan baku. Silakan tambahkan data baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
