<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name',
    'price',
    'description',
    'stock',
    'category_id',
    'image'
];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }
    // Relation avec les promotions
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    // Méthode pour obtenir la promotion active
    public function activePromotion()
    {
        return $this->promotions()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('active', true)
            ->first();
    }

    // Prix après réduction
    public function getDiscountedPriceAttribute()
    {
        $promotion = $this->activePromotion();
        
        if ($promotion) {
            $discount = ($this->price * $promotion->discount_percent) / 100;
            return $this->price - $discount;
        }
        
        return $this->price;
    }

    // Vérifier si le produit a une promotion
    public function hasActivePromotion()
    {
        return !is_null($this->activePromotion());
    }

    // Pourcentage de réduction
    public function getDiscountPercentAttribute()
    {
        $promotion = $this->activePromotion();
        return $promotion ? $promotion->discount_percent : 0;
    }

}
