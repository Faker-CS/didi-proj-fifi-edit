<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Promotion extends Model
{
    protected $fillable = [
        'product_id',
        'discount_percent',
        'start_date',
        'end_date',
        'active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


