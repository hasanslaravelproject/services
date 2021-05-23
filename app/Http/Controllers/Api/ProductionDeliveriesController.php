<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DeliveryCollection;

class ProductionDeliveriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        $search = $request->get('search', '');

        $deliveries = $production
            ->deliveries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeliveryCollection($deliveries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', Delivery::class);

        $validated = $request->validate([
            'quantity' => ['required', 'max:255', 'string'],
            'order_id' => ['nullable', 'exists:orders,id'],
        ]);

        $delivery = $production->deliveries()->create($validated);

        return new DeliveryResource($delivery);
    }
}
