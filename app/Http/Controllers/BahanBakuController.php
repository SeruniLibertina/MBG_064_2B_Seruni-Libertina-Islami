<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Carbon\Carbon;

class BahanBakuController extends Controller
{
    /**
     * Menampilkan daftar semua bahan baku.
     * Secara otomatis, fungsi ini juga akan mengupdate status bahan baku
     * berdasarkan tanggal kadaluarsa.
     */
    public function index()
    {
        // Ambil semua bahan baku, diurutkan berdasarkan tanggal kadaluarsa yang paling dekat
        $bahanBakus = BahanBaku::orderBy('tanggal_kadaluarsa', 'asc')->get();

        // Logika untuk update status otomatis
        foreach ($bahanBakus as $bahan) {
            $today = Carbon::today();
            // Tentukan batas 3 hari dari sekarang untuk penanda 'segera kadaluarsa'
            $threeDaysFromNow = Carbon::today()->addDays(3);
            $expiryDate = Carbon::parse($bahan->tanggal_kadaluarsa);
            $status = 'tersedia'; // Status default

            // Pengecekan status berdasarkan kondisi
            if ($bahan->jumlah == 0) {
                $status = 'habis';
            } elseif ($today->gt($expiryDate)) {
                $status = 'kadaluarsa';
            } elseif ($expiryDate->isBetween($today, $threeDaysFromNow)) {
                $status = 'segera_kadaluarsa';
            }

            // Simpan perubahan status hanya jika ada perbedaan, biar tidak boros query
            if ($bahan->status != $status) {
                $bahan->status = $status;
                $bahan->save();
            }
        }
        // Tampilkan halaman daftar bahan baku dengan data yang sudah diupdate
        return view('bahan_baku.index', ['bahanBakus' => $bahanBakus]);
    }

    /**
     * Menampilkan form untuk menambah bahan baku baru.
     */
    public function create()
    {
        return view('bahan_baku.create');
    }

    /**
     * Menyimpan data bahan baku baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        // Buat data baru di tabel bahan_bakus
        BahanBaku::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => 'tersedia', // Status awal saat bahan baku ditambahkan
        ]);

        // Arahkan kembali ke halaman utama
        return redirect()->route('bahan-baku.index');
    }

    /**
     * Menampilkan form untuk mengedit stok bahan baku.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.edit', ['bahan' => $bahanBaku]);
    }

    /**
     * Mengupdate jumlah stok bahan baku.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        // Validasi jumlah stok baru, tidak boleh kurang dari 1
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Update data jumlah
        $bahanBaku->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('bahan-baku.index');
    }

    /**
     * Menghapus data bahan baku dari database.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        // Hanya bahan baku yang sudah kadaluarsa yang bisa dihapus
        if ($bahanBaku->status != 'kadaluarsa') {
            return redirect()->route('bahan-baku.index')->with('error', 'Hanya bahan baku yang sudah kadaluarsa yang bisa dihapus.');
        }

        $bahanBaku->delete();

        return redirect()->route('bahan-baku.index');
    }

    /**
     * Menampilkan halaman konfirmasi sebelum menghapus.
     */
    public function confirmDelete(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.confirm-delete', ['bahan' => $bahanBaku]);
    }
}