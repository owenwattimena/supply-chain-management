<?php

namespace App\Models;

use App\Models\HargaBahanBaku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanBaku extends Model
{
    use HasFactory;
    protected $table = 'bahan_baku';

    /**
     * Get the satuan associated with the BahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function satuan(): HasOne
    {
        return $this->hasOne(Satuan::class, 'id', 'id_satuan');
    }

    /**
     * Get all of the harga for the BahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function harga(): HasMany
    {
        return $this->hasMany(HargaBahanBaku::class, 'id_bahan_baku', 'id');
    }

    /**
     * Get the supplier associated with the BahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supplier(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'di_buat_oleh');
    }

    /**
     * Get the stokSupplier associated with the BahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stokSupplier(): HasOne
    {
        return $this->hasOne(StokSupplier::class, 'id_bahan_baku', 'id');
    }

    /**
     * Get the stokPersediaan associated with the BahanBaku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stokPersediaan(): HasOne
    {
        return $this->hasOne(StokPersediaan::class, 'id_bahan_baku', 'id');
    }
}
