<?php

namespace App\Models;

use App\Models\BahanBaku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class DetailPesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan';
    public $timestamps = false;

    /**
     * Get the rawMaterial associated with the DetailPesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rawMaterial(): HasOne
    {
        return $this->hasOne(BahanBaku::class, 'id', 'id_bahan_baku');
    }

    /**
     * Get the harga associated with the DetailPesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function harga(): HasOne
    {
        return $this->HasOne(HargaBahanBaku::class, 'id', 'id_harga');
    }

    /**
     * Get the order that owns the DetailPesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(PemesananBahanBaku::class, 'id_pesanan', 'id');
    }
}
