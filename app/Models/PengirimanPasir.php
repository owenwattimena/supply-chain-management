<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengirimanPasir extends Model
{
    use HasFactory;
    protected $table = 'pengiriman_pasir';

    /**
     * Get the bahanBaku associated with the PengirimanPasir
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bahanBaku(): HasOne
    {
        return $this->hasOne(BahanBaku::class, 'id', 'id_bahan_baku');
    }

    /**
     * Get the dibuatOleh associated with the PengirimanPasir
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dibuatOleh(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'dibuat_oleh');
    }
}
