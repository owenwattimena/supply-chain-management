<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PenerimaanPesanan extends Model
{
    use HasFactory;
    protected $table = 'penerimaan_pesanan';

    /**
     * Get all of the fotoPenerimaan for the PenerimaanPesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fotoPenerimaan()
    {
        return $this->hasMany(FotoPenerimaanPesanan::class, 'id_penerimaan_pesanan', 'id');
    }

    /**
     * Get the fotoPenerimaan that owns the PenerimaanPesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function fotoPenerimaan(): BelongsTo
    // {
    //     return $this->belongsTo(FotoPenerimaanPesanan::class, 'id_peneriman_pesanan', 'id');
    // }
    
}
