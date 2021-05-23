<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FinishedProductStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\FinishedProductStockResource;
use App\Http\Resources\FinishedProductStockCollection;

class FinishedProductStockFinishedProductStocksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('view', $finishedProductStock);

        $search = $request->get('search', '');

        $finishedProductStocks = $finishedProductStock
            ->finishedProductStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new FinishedProductStockCollection($finishedProductStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('create', FinishedProductStock::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'validity' => ['required', 'max:255', 'string'],
            'production_id' => ['nullable', 'exists:productions,id'],
        ]);

        $finishedProductStock = $finishedProductStock
            ->finishedProductStocks()
            ->create($validated);

        return new FinishedProductStockResource($finishedProductStock);
    }
}
