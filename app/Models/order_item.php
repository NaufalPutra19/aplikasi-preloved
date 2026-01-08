<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    use HasFactory;

    protected $table = 'orders_item';
    
    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(item::class, 'item_id');
    }
}
