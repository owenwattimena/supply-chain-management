<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerja extends Model
{
    use HasFactory;
    protected $table = 'pekerja';

    /**
     * Get all of the kehadiran for the Pekerja
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'id_pekerja', 'id');
    }
}
