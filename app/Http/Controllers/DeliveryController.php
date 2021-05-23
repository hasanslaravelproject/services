<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Delivery;
use App\Models\Production;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.deliveries.index', compact('deliveries', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Delivery::class);

        $productions = Production::pluck('name', 'id');
        $orders = Order::pluck('quantity', 'id');

        return view('app.deliveries.create', compact('productions', 'orders'));
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

        return redirect()
            ->route('deliveries.edit', $delivery)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Delivery $delivery)
    {
        $this->authorize('view', $delivery);

        return view('app.deliveries.show', compact('delivery'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Delivery $delivery)
    {
        $this->authorize('update', $delivery);

        $productions = Production::pluck('name', 'id');
        $orders = Order::pluck('quantity', 'id');

        return view(
            'app.deliveries.edit',
            compact('delivery', 'productions', 'orders')
        );
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

        return redirect()
            ->route('deliveries.edit', $delivery)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('deliveries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
