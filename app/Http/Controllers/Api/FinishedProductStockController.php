<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FinishedProductStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\FinishedProductStockResource;
use App\Http\Resources\FinishedProductStockCollection;
use App\Http\Requests\FinishedProductStockStoreRequest;
use App\Http\Requests\FinishedProductStockUpdateRequest;

class FinishedProductStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FinishedProductStock::class);

        $search = $request->get('search', '');

        $finishedProductStocks = FinishedProductStock::search($search)
            ->latest()
            ->paginate();

        return new FinishedProductStockCollection($finishedProductStocks);
    }

    /**
     * @param \App\Http\Requests\FinishedProductStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinishedProductStockStoreRequest $request)
    {
        $this->authorize('create', FinishedProductStock::class);

        $validated = $request->validated();

        $finishedProductStock = FinishedProductStock::create($validated);

        return new FinishedProductStockResource($finishedProductStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('view', $finishedProductStock);

        return new FinishedProductStockResource($finishedProductStock);
    }

    /**
     * @param \App\Http\Requests\FinishedProductStockUpdateRequest $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        FinishedProductStockUpdateRequest $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('update', $finishedProductStock);

        $validated = $request->validated();

        $finishedProductStock->update($validated);

        return new FinishedProductStockResource($finishedProductStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('delete', $finishedProductStock);

        $finishedProductStock->delete();

        return response()->noContent();
    }
}
