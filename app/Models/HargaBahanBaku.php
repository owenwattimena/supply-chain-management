<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'harga_bahan_baku';
    public $timestamps = false;
}
