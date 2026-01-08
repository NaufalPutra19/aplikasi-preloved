<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_cost',
        'tax',
        'status',
        'payment_status',
        'payment_method',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
        'shipping_phone',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(order_item::class, 'order_id');
    }
}
