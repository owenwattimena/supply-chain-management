<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailProduksi extends Model
{
    use HasFactory;
    protected $table = 'detail_produksi';

    /**
     * Get the bahanBaku associated with the DetailProduksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bahanBaku(): HasOne
    {
        return $this->hasOne(BahanBaku::class, 'id', 'id_bahan_baku');
    }
}
