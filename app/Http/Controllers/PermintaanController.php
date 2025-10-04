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
     * Menampilkan form untuk membuat permintaan baru.
     */
        public function index()
    {
        // Ambil semua permintaan milik user yang sedang login, urutkan dari yang terbaru
        $permintaans = Permintaan::where('pemohon_id', auth()->id())
                                ->with('details.bahanBaku') // Mengambil detail & nama bahan sekaligus
                                ->latest() // Mengurutkan dari yang paling baru
                                ->get();

        return view('permintaan.index', ['permintaans' => $permintaans]);
    }

    public function create()
    {
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
        $request->validate([
            'tgl_masak' => 'required|date|after_or_equal:today',
            'menu_makan' => 'required|string',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan' => 'required|array|min:1',
        ], [
            'bahan.required' => 'Anda harus memilih minimal satu bahan baku.'
        ]);

        DB::transaction(function () use ($request) {
            $permintaan = Permintaan::create([
                'pemohon_id' => Auth::id(),
                'tgl_masak' => $request->tgl_masak,
                'menu_makan' => $request->menu_makan,
                'jumlah_porsi' => $request->jumlah_porsi,
                'status' => 'menunggu',
            ]);

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

        return redirect()->route('dashboard'); // Kita akan ubah ini nanti
    }
}