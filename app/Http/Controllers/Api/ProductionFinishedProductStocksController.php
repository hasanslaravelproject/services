<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FinishedProductStockResource;
use App\Http\Resources\FinishedProductStockCollection;

class ProductionFinishedProductStocksController extends Controller
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

        $finishedProductStocks = $production
            ->finishedProductStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new FinishedProductStockCollection($finishedProductStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', FinishedProductStock::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'validity' => ['required', 'max:255', 'string'],
            'finished_product_stock_id' => [
                'nullable',
                'exists:finished_product_stocks,id',
            ],
        ]);

        $finishedProductStock = $production
            ->finishedProductStocks()
            ->create($validated);

        return new FinishedProductStockResource($finishedProductStock);
    }
}
