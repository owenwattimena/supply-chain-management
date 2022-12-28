<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;
    protected $table = 'kehadiran';

    /**
     * Get the pekerja that owns the Kehadiran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pekerja(): BelongsTo
    {
        return $this->belongsTo(Pekerja::class, 'id_pekerja', 'id');
    }
}
