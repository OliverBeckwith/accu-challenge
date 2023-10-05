<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class BotNameGenerator
{
    /** Retrieve the most prevalent category from the order items */
    protected function getOrderCategory(Order $order)
    {
        $productCategories = [];
        foreach ($order->orderItems as $orderItem) {
            $product = Product::find($orderItem->product_sku);
            if (!$product) continue;

            // Add product category for each of the item in the order
            $productCategories = [
                ...$productCategories,
                ...array_fill(0, $orderItem->quantity, $product->category)
            ];
        }

        // Get counts for each of the categories, then reverse sort to get highest count
        $counts = array_count_values($productCategories);
        arsort($counts);

        return array_keys($counts)[0];
    }

    /** Generate a bot name for the given order */
    public function generate(Order $order)
    {
        $orderCategory = $this->getOrderCategory($order);

        //TODO: Replace placeholder below with generated bot name
        return "Nutzilla";
    }
}
