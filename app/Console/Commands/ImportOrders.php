<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;

class ImportOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-orders {csv_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports orders and order items from ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Started import orders");
        $csvFile = $this->argument("csv_file");
        $csvData = file_get_contents($csvFile);
        // Read rows.
        // TODO: Instead read with headers and use to generate keyed array
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $count = count($rows);
        $this->info("Importing {$count} order items");

        $errors = [];
        $this->withProgressBar($rows, function (array $row) use ($errors) {
            if (count($row) !== 4) {
                $errors[] = "Row does not match expected format";
                return;
            }
            // Destructure CSV row. 
            // TODO: add validation here.
            [$orderId, $customerName, $sku, $quantity] = $row;

            // If the orderId is not an integer - break
            if (!ctype_digit($orderId)) {
                $errors[] = "Order ID not an integer";
                return;
            }

            // Ensure parent order exists
            Order::updateOrCreate([
                'id' => $orderId,
                'customer_name' => $customerName,
            ]);

            // Add order item
            OrderItem::create([
                'order_id' => $orderId,
                'product_sku' => $sku,
                'quantity' => $quantity,
            ]);
        });
        foreach ($errors as $error) {
            $this->error($error);
        }

        $this->info("Finished import orders");
    }
}
