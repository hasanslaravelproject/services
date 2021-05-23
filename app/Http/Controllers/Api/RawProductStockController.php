<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RawProductStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RawProductStockResource;
use App\Http\Resources\RawProductStockCollection;
use App\Http\Requests\RawProductStockStoreRequest;
use App\Http\Requests\RawProductStockUpdateRequest;

class RawProductStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RawProductStock::class);

        $search = $request->get('search', '');

        $rawProductStocks = RawProductStock::search($search)
            ->latest()
            ->paginate();

        return new RawProductStockCollection($rawProductStocks);
    }

    /**
     * @param \App\Http\Requests\RawProductStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RawProductStockStoreRequest $request)
    {
        $this->authorize('create', RawProductStock::class);

        $validated = $request->validated();

        $rawProductStock = RawProductStock::create($validated);

        return new RawProductStockResource($rawProductStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RawProductStock $rawProductStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RawProductStock $rawProductStock)
    {
        $this->authorize('view', $rawProductStock);

        return new RawProductStockResource($rawProductStock);
    }

    /**
     * @param \App\Http\Requests\RawProductStockUpdateRequest $request
     * @param \App\Models\RawProductStock $rawProductStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        RawProductStockUpdateRequest $request,
        RawProductStock $rawProductStock
    ) {
        $this->authorize('update', $rawProductStock);

        $validated = $request->validated();

        $rawProductStock->update($validated);

        return new RawProductStockResource($rawProductStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RawProductStock $rawProductStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RawProductStock $rawProductStock)
    {
        $this->authorize('delete', $rawProductStock);

        $rawProductStock->delete();

        return response()->noContent();
    }
}
