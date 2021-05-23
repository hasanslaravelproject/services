<?php

namespace App\Http\Controllers\Api;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DeliveryCollection;
use App\Http\Requests\DeliveryStoreRequest;
use App\Http\Requests\DeliveryUpdateRequest;

class DeliveryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Delivery::class);

        $search = $request->get('search', '');

        $deliveries = Delivery::search($search)
            ->latest()
            ->paginate();

        return new DeliveryCollection($deliveries);
    }

    /**
     * @param \App\Http\Requests\DeliveryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryStoreRequest $request)
    {
        $this->authorize('create', Delivery::class);

        $validated = $request->validated();

        $delivery = Delivery::create($validated);

        return new DeliveryResource($delivery);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Delivery $delivery)
    {
        $this->authorize('view', $delivery);

        return new DeliveryResource($delivery);
    }

    /**
     * @param \App\Http\Requests\DeliveryUpdateRequest $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryUpdateRequest $request, Delivery $delivery)
    {
        $this->authorize('update', $delivery);

        $validated = $request->validated();

        $delivery->update($validated);

        return new DeliveryResource($delivery);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Delivery $delivery)
    {
        $this->authorize('delete', $delivery);

        $delivery->delete();

        return response()->noContent();
    }
}
