<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class item extends Model
{
    use HasFactory;

    protected $table = 'items';
    
    protected $fillable = [
        'sku', 'name', 'category_id', 'unit_id', 'stock', 'stock_min',
        'price', 'description', 'condition', 'image', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(categories::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function orderItems()
    {
        return $this->hasMany(order_item::class);
    }
}
