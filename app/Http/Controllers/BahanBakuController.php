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

        // Logika untuk update status otomatis sesuai aturan PDF
        foreach ($bahanBakus as $bahan) {
            $today = Carbon::today();
            $expiryDate = Carbon::parse($bahan->tanggal_kadaluarsa);
            $status = 'tersedia';

            if ($bahan->jumlah == 0) $status = 'habis';
            elseif ($today->gt($expiryDate)) $status = 'kadaluarsa';
            elseif ($expiryDate->diffInDays($today) <= 3) $status = 'segera_kadaluarsa';

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
