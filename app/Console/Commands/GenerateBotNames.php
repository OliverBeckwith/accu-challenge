<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;

class GenerateBotNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-bots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates bot names for orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Started generation of bot names for orders");

        $orders = Order::all();

        $count = count($orders);
        $this->info("Generating {$count} bot names for orders");

        $this->withProgressBar($orders, function (Order $order) {
            $order->getBotName();
        });

        $this->info("Finished generating bot names");
    }
}
