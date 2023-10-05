<?php

namespace App\Models;

use App\Services\BotNameGenerator;
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
            fn ($orderItem) => ($orderItem->product->weight ?? 0) * ($orderItem->quantity ?? 1)
        );
    }

    /** Get's the bot name for this order. If not present, generates one. */
    public function getBotName()
    {
        if ($this->bot_name) return $this->bot_name;

        $botGenerator = resolve(BotNameGenerator::class);
        $botName = $botGenerator->generate($this);
        $this->bot_name = $botName;
        $this->save();
        return $botName;
    }
}
