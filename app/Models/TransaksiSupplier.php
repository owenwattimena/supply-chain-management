<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiSupplier extends Model
{
    use HasFactory;
    protected $table = 'transaksi_supplier';

    /**
     * Get the user associated with the TransaksiSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'dibuat_oleh');
    }

    /**
     * Get all of the items for the TransaksiSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(DetailTransaksiSupplier::class, 'id_transaksi_supplier', 'id');
    }
}
