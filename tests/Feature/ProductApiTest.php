<?php

namespace Tests\Unit;

use App\Services\ProductApi;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    protected ProductApi $productApi;

    protected function setUp(): void
    {
        $this->productApi = resolve(ProductApi::class);
        parent::setUp();
    }

    public function test_that_the_product_count_exists(): void
    {
        $count = $this->productApi->getTotalCount();
        $this->assertGreaterThan(0, $count);
    }

    public function test_that_product_structure_is_correct(): void
    {
        $product = $this->productApi->fetch()[0];

        $this->assertArrayHasKey("sku", $product);
        $this->assertArrayHasKey("product_name", $product);
        $this->assertArrayHasKey("category", $product);
        $this->assertArrayHasKey("weight", $product);
    }

    public function test_that_the_api_paginates(): void
    {
        $productFirstPage = $this->productApi->fetch()[0];
        $productSecondPage = $this->productApi->fetch(1)[0];

        $this->assertNotEquals($productFirstPage['sku'], $productSecondPage['sku']);
    }
}
