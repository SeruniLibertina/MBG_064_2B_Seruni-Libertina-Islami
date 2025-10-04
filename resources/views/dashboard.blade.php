@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Dashboard</h1>
        </div>
        <div class="card-body">
            <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>
            <p>Anda login sebagai Petugas <strong>{{ auth()->user()->role }}</strong>.</p>

            @if(auth()->user()->role == 'dapur')
                <a href="{{ route('permintaan.create') }}" class="btn btn-primary mt-3">Buat Permintaan Bahan Baku</a>
                <a href="{{ route('permintaan.index') }}" class="btn btn-secondary mt-3">Lihat Riwayat Permintaan</a>
                @endif
        </div>
    </div>
</div>
@endsection