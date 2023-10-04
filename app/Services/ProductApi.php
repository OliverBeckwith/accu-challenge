<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductApi
{

    protected const ENDPOINT_URL = "https://nt5gkznl19.execute-api.eu-west-1.amazonaws.com/prod/products";

    public const PAGE_SIZE = 10;

    /** Get the total count of products available in the API endpoint */
    public function getTotalCount(): int
    {
        // Make call but request no products
        $response = Http::get(self::ENDPOINT_URL, [
            "\$skip" => 0,
            "\$top" => 0,
        ]);
        if (!$response->successful()) {
            throw new \Exception("Error {$response->status()}");
        }
        $responseData = $response->json();
        return $responseData['@odata.count'] ?? 0;
    }

    /** Fetch product data */
    public function fetch(int $page = 0): array
    {
        $response = Http::get(self::ENDPOINT_URL, [
            "\$skip" => $page * self::PAGE_SIZE,
            "\$top" => self::PAGE_SIZE,
        ]);

        if (!$response->successful()) {
            throw new \Exception("Error {$response->status()}");
        }

        $responseData = $response->json();

        return $responseData['value'] ?? [];
    }
}
