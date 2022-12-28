<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksi';

    /**
     * Get the produk associated with the Produksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function produk(): HasOne
    {
        return $this->hasOne(Produk::class, 'id', 'id_produk');
    }

    /**
     * Get all of the detail for the Produksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail(): HasMany
    {
        return $this->hasMany(DetailProduksi::class, 'id_produksi', 'id');
    }

    /**
     * Get all of the kehadiran for the Produksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'id_produksi', 'id');
    }
}
