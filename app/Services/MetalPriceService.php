<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MetalPriceService
{
    private const API_BASE_URL = 'https://api.gold-api.com/price';
    private const CACHE_TTL = 300; // 5 minutes in seconds

    public function getGoldPrice(): ?array
    {
        return $this->getPrice('XAU', 'gold');
    }

    public function getSilverPrice(): ?array
    {
        return $this->getPrice('XAG', 'silver');
    }

    public function getAllPrices(): array
    {
        return [
            'gold' => $this->getGoldPrice(),
            'silver' => $this->getSilverPrice(),
            'fetched_at' => now()->toIso8601String(),
        ];
    }

    private function getPrice(string $symbol, string $cacheKey): ?array
    {
        return Cache::remember("metal_price_{$cacheKey}", self::CACHE_TTL, function () use ($symbol) {
            try {
                $response = Http::withoutVerifying()->timeout(10)->get(self::API_BASE_URL . '/' . $symbol);

                if ($response->successful()) {
                    $data = $response->json();

                    // Price is per troy ounce, calculate per gram (1 troy oz = 31.1035 grams)
                    $pricePerOz = $data['price'] ?? 0;
                    $pricePerGram = $pricePerOz / 31.1035;

                    return [
                        'name' => $data['name'] ?? $symbol,
                        'symbol' => $data['symbol'] ?? $symbol,
                        'price_per_oz' => round($pricePerOz, 2),
                        'price_per_gram' => round($pricePerGram, 2),
                        'updated_at' => $data['updatedAt'] ?? now()->toIso8601String(),
                    ];
                }

                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    public function clearCache(): void
    {
        Cache::forget('metal_price_gold');
        Cache::forget('metal_price_silver');
    }
}
