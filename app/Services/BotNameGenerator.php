<?php

namespace App\Services;

use App\Models\BotName;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Env;
use OpenAI\Client;
use OpenAI;

class BotNameGenerator
{
    private Client $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env("OPENAI_API_KEY"));
    }

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

    /** Use OpenAI GPT 3.5 to generate an amusing bot name */
    protected function generateBotNameWithOpenAI(string $category): string|null
    {
        $chatResponse = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'temperature' => 0.7, //Allow creativity
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Generate a single word amusing robot name loosely based on the specified category: '$category'." . PHP_EOL
                    . "(Examples: 'Boltinator', 'Nutbuster', 'Washzilla')" . PHP_EOL
                    . "Your response should only be a single word: the robot name."
                ]
            ],
        ]);
        $botName = null;
        foreach ($chatResponse->choices as $result) {
            if ($result->finishReason === 'stop') {
                $botName = trim($result->message->content);
            }
        }
        return $botName;
    }

    /** Generate a bot name for the given order */
    public function generate(Order $order)
    {
        $orderCategory = $this->getOrderCategory($order);

        $existingBot = BotName::find($orderCategory);
        if ($existingBot && !empty($existingBot->bot_name)) {
            return $existingBot->bot_name;
        }

        $fallbackBotName = "Boltinator";
        $openAiBotName = $this->generateBotNameWithOpenAI($orderCategory);

        if ($openAiBotName) {
            //Cache for later use
            BotName::create([
                'category' => $orderCategory,
                'bot_name' => $openAiBotName,
            ]);
        }

        return $openAiBotName ?? $fallbackBotName;
    }
}
