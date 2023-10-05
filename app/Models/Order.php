<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['customer_name', 'bot_name'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalWeight()
    {
        return $this->orderItems->sum(
            fn ($orderItem) => ($orderItem->weight ?? 0) * ($orderItem->quantity ?? 1)
        );
    }
}
