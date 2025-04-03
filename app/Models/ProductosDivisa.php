<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosDivisa extends Model
{
    /** @use HasFactory<\Database\Factories\ProductosDivisaFactory> */
    use HasFactory;

    protected $fillable = ['producto_id', 'divisa_id', 'price'];

    public function product()
    {
        return $this->belongsTo(Producto::class);
    }

    public function currency()
    {
        return $this->belongsTo(Divisa::class);
    }
}
