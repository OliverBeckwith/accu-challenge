<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductApi;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports products from the product API';

    protected ProductApi $productApi;

    public function __construct(ProductApi $productApi)
    {
        $this->productApi = $productApi;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Started import products");

        $productCount = $this->productApi->getTotalCount();

        $this->info("Importing {$productCount} products");

        $pages = ceil($productCount / $this->productApi::PAGE_SIZE);

        $progressBar = $this->output->createProgressBar($productCount);
        foreach (range(0, $pages) as $page) {
            $products = $this->productApi->fetch($page);

            foreach ($products as $product) {
                if (!empty($product['sku'])) {
                    Product::updateOrCreate([
                        'sku' => $product['sku'],
                        'name' => $product['product_name'],
                        'category' => $product['category'],
                        'weight' => $product['weight'],
                    ]);
                }
                $progressBar->advance();
            }
        }
        $progressBar->finish();
        $this->newLine();
        $this->info("Finished import products");
    }
}
