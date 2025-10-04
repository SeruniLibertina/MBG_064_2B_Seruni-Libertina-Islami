<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'permintaan_id',
        'bahan_id',
        'jumlah_diminta',
    ];

    // Relasi: Satu detail milik satu Permintaan
    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class);
    }

    // Relasi: Satu detail merujuk ke satu BahanBaku
    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}