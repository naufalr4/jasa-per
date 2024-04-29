<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id');
    }
    public function jasa()
    {
        return $this->belongsTo(Jasa::class, 'id_jasa', 'id');
        return $this->belongsTo(Jasa::class, 'nama_jasa', 'nama_jasa');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
