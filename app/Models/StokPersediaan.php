<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokPersediaan extends Model
{
    use HasFactory;
    protected $table = 'stok_persediaan';

    /**
     * Get the rawMaterial associated with the StokPersediaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rawMaterial(): HasOne
    {
        return $this->hasOne(BahanBaku::class, 'id', 'id_bahan_baku');
    }
}
