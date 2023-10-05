<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BotNameGenerator;
use Tests\TestCase;

class BotNameGeneratorTest extends TestCase
{
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
        Order::create([
            'id' => $orderIndex,
            'customer_name' => 'Gary',
        ]);
        OrderItem::create([
            'order_id' => $orderIndex,
            'product_sku' => $productSku,
            'quantity' => 1
        ]);

        return Order::find(1);
    }

    public function test_that_bot_names_are_generated(): void
    {
        $gearOrder = $this->makeTestOrder("Gears");
        $botName = $this->botNameGenerator->generate($gearOrder);
        echo "BOT NAME: " . $botName;
        $this->assertIsString($botName);
    }

    public function test_that_bot_names_are_generated_differently(): void
    {
        $gearOrder = $this->makeTestOrder("Gears");
        $springOrder = $this->makeTestOrder("Springs");
        $gearBotName = $this->botNameGenerator->generate($gearOrder);
        $springBotName = $this->botNameGenerator->generate($springOrder);
        $this->assertNotEquals($gearBotName, $springBotName);
    }
}
