<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    protected $table = 'products';
    protected $primaryKey = 'sku';
    public $incrementing = false;
    protected $fillable = ['sku', 'name', 'category', 'weight'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
