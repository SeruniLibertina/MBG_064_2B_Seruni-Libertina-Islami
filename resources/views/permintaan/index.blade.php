@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Riwayat Permintaan Bahan Baku</h1>
        <a href="{{ route('permintaan.create') }}" class="btn btn-pink">Buat Permintaan Baru</a>
    </div>

    @forelse ($permintaans as $permintaan)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>
                    <strong>Menu:</strong> {{ $permintaan->menu_makan }} ({{ $permintaan->jumlah_porsi }} Porsi)
                </span>
                <span>
                    <strong>Status:</strong>
                    @if($permintaan->status == 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($permintaan->status == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </span>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Masak:</strong> {{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</p>
                <h6>Bahan yang diminta:</h6>
                <ul>
                    @foreach ($permintaan->details as $detail)
                        <li>{{ $detail->bahanBaku->nama }} - {{ $detail->jumlah_diminta }} {{ $detail->bahanBaku->satuan }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-muted">
                Dibuat pada: {{ $permintaan->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Anda belum pernah membuat permintaan.
        </div>
    @endforelse
</div>
@endsection