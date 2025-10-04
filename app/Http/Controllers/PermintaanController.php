<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    /**
     * Menampilkan riwayat permintaan bahan baku dari user yang sedang login.
     */
    public function index()
    {
        // Ambil data permintaan, diurutkan dari yang terbaru
        $permintaans = Permintaan::where('pemohon_id', auth()->id())
                                ->with('details.bahanBaku') // Eager loading untuk mengambil relasi
                                ->latest()
                                ->get();

        return view('permintaan.index', ['permintaans' => $permintaans]);
    }

    /**
     * Menampilkan form untuk membuat permintaan baru.
     */
    public function create()
    {
        // Ambil bahan baku yang stoknya masih ada dan belum kadaluarsa
        $bahanBakus = BahanBaku::where('jumlah', '>', 0)
                                ->whereIn('status', ['tersedia', 'segera_kadaluarsa'])
                                ->orderBy('nama', 'asc')
                                ->get();

        return view('permintaan.create', ['bahanBakus' => $bahanBakus]);
    }

    /**
     * Menyimpan permintaan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tgl_masak' => 'required|date|after_or_equal:today',
            'menu_makan' => 'required|string',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan' => 'required|array|min:1',
        ], [
            'bahan.required' => 'Pilih minimal satu bahan baku yang dibutuhkan.'
        ]);

        // Gunakan transaction untuk memastikan semua query berhasil
        DB::transaction(function () use ($request) {
            // Buat data permintaan utama
            $permintaan = Permintaan::create([
                'pemohon_id' => Auth::id(),
                'tgl_masak' => $request->tgl_masak,
                'menu_makan' => $request->menu_makan,
                'jumlah_porsi' => $request->jumlah_porsi,
                'status' => 'menunggu', // Status awal permintaan
            ]);

            // Simpan detail bahan baku yang diminta
            foreach ($request->bahan as $bahan_id => $detail) {
                if (isset($detail['id']) && isset($detail['jumlah'])) {
                    PermintaanDetail::create([
                        'permintaan_id' => $permintaan->id,
                        'bahan_id' => $bahan_id,
                        'jumlah_diminta' => $detail['jumlah'],
                    ]);
                }
            }
        });

        // Arahkan kembali ke dashboard setelah berhasil
        return redirect()->route('dashboard');
    }
}