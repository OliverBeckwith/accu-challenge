<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BotNameGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotNameGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected BotNameGenerator $botNameGenerator;

    protected function setUp(): void
    {
        $this->botNameGenerator = resolve(BotNameGenerator::class);
        parent::setUp();
    }

    protected function makeTestOrder(string $category)
    {
        static $testIndex = 0;
        $orderIndex = $testIndex++;
        $productSku = "TEST-" . $orderIndex;
        Product::create([
            'sku' => $productSku,
            'name' => "Test $category Product",
            'category' => $category,
            'weight' => 1.0,
        ]);
        $order = Order::create([
            'id' => $orderIndex,
            'customer_name' => 'Gary',
        ]);
        OrderItem::create([
            'order_id' => $orderIndex,
            'product_sku' => $productSku,
            'quantity' => 1
        ]);

        return $order;
    }

    public function test_that_bot_names_are_generated(): void
    {
        $gearOrder = $this->makeTestOrder("Gears");
        $botName = $this->botNameGenerator->generate($gearOrder);
        $this->assertIsString($botName);
    }
}
