<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datajasa extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(category::class, 'id_kategori', 'id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_subkategori', 'id');
    }
}
