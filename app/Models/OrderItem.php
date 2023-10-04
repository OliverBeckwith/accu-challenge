<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['order_id', 'product_sku', 'quantity'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
