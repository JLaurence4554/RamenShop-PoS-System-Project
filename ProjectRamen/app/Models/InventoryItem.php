<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'min_stock',
        'unit_price',
        'supplier'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'min_stock' => 'decimal:2',
        'unit_price' => 'decimal:2',
    ];

    // Get status based on quantity
    public function getStatusAttribute()
    {
        if ($this->quantity == 0) {
            return 'out-of-stock';
        } elseif ($this->quantity <= $this->min_stock) {
            return 'low-stock';
        }
        return 'in-stock';
    }

    // Get total value
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    // Scope for low stock items
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_stock')->where('quantity', '>', 0);
    }

    // Scope for out of stock items
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    // Scope for in stock items
    public function scopeInStock($query)
    {
        return $query->whereRaw('quantity > min_stock');
    }

    // Scope for filtering by category
    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    // Scope for searching
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function productRecipes()
        {
            return $this->hasMany(ProductRecipe::class);
        }

        public function products()
        {
            return $this->belongsToMany(Product::class, 'product_recipes')
                        ->withPivot('quantity_needed')
                        ->withTimestamps();
        }
}
