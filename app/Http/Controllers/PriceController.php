<?php

namespace App\Http\Controllers;

use App\Services\MetalPriceService;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    public function __construct(private MetalPriceService $priceService)
    {
    }

    public function index(): JsonResponse
    {
        $prices = $this->priceService->getAllPrices();

        return response()->json($prices);
    }

    public function refresh(): JsonResponse
    {
        $this->priceService->clearCache();
        $prices = $this->priceService->getAllPrices();

        return response()->json($prices);
    }
}
