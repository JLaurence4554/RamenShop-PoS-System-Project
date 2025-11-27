<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class);
    }

    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'product_recipes')
                    ->withPivot('quantity_needed')
                    ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
