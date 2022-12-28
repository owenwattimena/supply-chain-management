<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemesananBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'pemesanan_bahan_baku';


    /**
     * Get the supplier associated with the PemesananBahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supplier(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_supplier');
    }

    /**
     * Get all of the material for the PemesananBahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function material(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id');
    }

    /**
     * Get the cancelBy associated with the PemesananBahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cancelBy(): HasOne  
    {
        return $this->hasOne(User::class, 'id', 'dibatalkan_oleh');
    }

    /**
     * Get the transaksiSupplier associated with the PemesananBahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penerimaanPesanan(): HasOne
    {
        return $this->hasOne(PenerimaanPesanan::class, 'id_pemesanan_bahan_baku', 'id');
    }
}
