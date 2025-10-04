@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h2>Dashboard</h2>
                </div>
                <div class="card-body p-5">
                    <h4 class="mb-3">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</h4>
                    <p class="lead">Anda login sebagai Petugas <strong>{{ auth()->user()->role }}</strong>.</p>

                    @if(auth()->user()->role == 'dapur')
                        <div class="mt-4">
                            <a href="{{ route('permintaan.create') }}" class="btn btn-primary">
                                Buat Permintaan Baru
                            </a>
                            <a href="{{ route('permintaan.index') }}" class="btn btn-secondary ms-2">
                                Lihat Riwayat Permintaan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
