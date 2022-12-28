<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaksiSupplier extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi_supplier';

    public $timestamps = false;

    /**
     * Get the bahanBaku that owns the DetailTransaksiSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id');
    }
}
