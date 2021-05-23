<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DeliveryCollection;

class OrderDeliveriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $deliveries = $order
            ->deliveries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeliveryCollection($deliveries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        $this->authorize('create', Delivery::class);

        $validated = $request->validate([
            'quantity' => ['required', 'max:255', 'string'],
            'production_id' => ['nullable', 'exists:productions,id'],
        ]);

        $delivery = $order->deliveries()->create($validated);

        return new DeliveryResource($delivery);
    }
}
