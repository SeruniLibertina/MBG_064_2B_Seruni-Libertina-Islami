@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Permintaan Bahan Baku Baru</h1>

    <form action="{{ route('permintaan.store') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">Detail Rencana Masak</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tgl_masak" class="form-label">Tanggal Rencana Masak</label>
                        <input type="date" class="form-control" id="tgl_masak" name="tgl_masak" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jumlah_porsi" class="form-label">Jumlah Porsi</label>
                        <input type="number" class="form-control" id="jumlah_porsi" name="jumlah_porsi" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="menu_makan" class="form-label">Deskripsi Menu</label>
                    <textarea class="form-control" id="menu_makan" name="menu_makan" rows="3" required></textarea>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Pilih Bahan Baku yang Dibutuhkan</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Nama Bahan</th>
                            <th>Sisa Stok</th>
                            <th>Jumlah Diminta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bahanBakus as $bahan)
                        <tr>
                            <td>
                                <input class="form-check-input" type="checkbox" name="bahan[{{ $bahan->id }}][id]" value="{{ $bahan->id }}">
                            </td>
                            <td>{{ $bahan->nama }}</td>
                            <td>{{ $bahan->jumlah }} {{ $bahan->satuan }}</td>
                            <td>
                                <input type="number" name="bahan[{{ $bahan->id }}][jumlah]" class="form-control" min="1" max="{{ $bahan->jumlah }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajukan Permintaan</button>
    </form>
</div>
@endsection