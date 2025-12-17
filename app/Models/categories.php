<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function items()
    {
        return $this->hasMany(item::class, 'category_id');
    }
}