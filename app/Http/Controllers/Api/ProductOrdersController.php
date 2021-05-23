<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class ProductOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $orders = $product
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'number' => ['required', 'max:255'],
            'delivery_date' => ['required', 'date', 'date'],
            'quantity' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $order = $product->orders()->create($validated);

        return new OrderResource($order);
    }
}
