<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\BasketItem;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'basket' => 'required|array',
            'basket.*.name' => 'required|string',
            'basket.*.type' => 'required|string',
            'basket.*.price' => 'required|numeric',
        ]);

        $order = Order::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
        ]);

        foreach ($validated['basket'] as $item) {
            $basketItem = $order->basketItems()->create($item);

            if ($item['type'] === 'subscription') {
                dispatch(function () use ($item) {
                    Http::post('https://very-slow-api.com/orders', [
                        'ProductName' => $item['name'],
                        'Price' => $item['price'],
                        'Timestamp' => now(),
                    ]);
                })->afterResponse();
            }
        }

        return response()->json(['message' => 'Order created successfully.'], 201);
    }
}
