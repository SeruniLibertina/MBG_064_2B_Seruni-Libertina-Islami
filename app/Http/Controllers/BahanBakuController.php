<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Carbon\Carbon;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanBakus = BahanBaku::orderBy('tanggal_kadaluarsa', 'asc')->get();

        // Logika untuk update status otomatis
        foreach ($bahanBakus as $bahan) {
            $today = Carbon::today();
            // Tentukan batas 3 hari dari sekarang
            $threeDaysFromNow = Carbon::today()->addDays(3);
            $expiryDate = Carbon::parse($bahan->tanggal_kadaluarsa);
            $status = 'tersedia';

            if ($bahan->jumlah == 0) {
                $status = 'habis';
            // 1. Cek dulu apakah sudah lewat tanggal kadaluarsa
            } elseif ($today->gt($expiryDate)) {
                $status = 'kadaluarsa';
            // 2. LOGIKA BARU: Cek apakah tanggalnya ada di antara hari ini dan 3 hari ke depan
            } elseif ($expiryDate->isBetween($today, $threeDaysFromNow)) {
                $status = 'segera_kadaluarsa';
            }

            // Simpan perubahan status ke database hanya jika statusnya berbeda
            if ($bahan->status != $status) {
                $bahan->status = $status;
                $bahan->save();
            }
        }
        return view('bahan_baku.index', ['bahanBakus' => $bahanBakus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('bahan_baku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input sesuai aturan di PDF
        $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        // Simpan data ke database
        BahanBaku::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => 'tersedia', // Status awal 'Tersedia' sesuai PDF
        ]);

        // Arahkan kembali ke halaman utama dengan pesan sukses
        return redirect()->route('bahan-baku.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.edit', ['bahan' => $bahanBaku]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        // Sistem harus menolak update jika nilai stok < 0
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $bahanBaku->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('bahan-baku.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        // Sistem hanya mengizinkan penghapusan bahan baku yang berstatus kadaluarsa
        if ($bahanBaku->status != 'kadaluarsa') {
            return redirect()->route('bahan-baku.index'); // Atau beri pesan error
        }

        $bahanBaku->delete();

        return redirect()->route('bahan-baku.index');
    }

        public function confirmDelete(BahanBaku $bahanBaku)
    {
        // Menampilkan data bahan baku yang akan dihapus
        return view('bahan_baku.confirm-delete', ['bahan' => $bahanBaku]);
    }
}
