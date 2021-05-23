<?php

namespace App\Http\Controllers\Api;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RawProductStockResource;
use App\Http\Resources\RawProductStockCollection;

class IngredientRawProductStocksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Ingredient $ingredient)
    {
        $this->authorize('view', $ingredient);

        $search = $request->get('search', '');

        $rawProductStocks = $ingredient
            ->rawProductStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RawProductStockCollection($rawProductStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ingredient $ingredient)
    {
        $this->authorize('create', RawProductStock::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'expiry_date' => ['required', 'date', 'date'],
        ]);

        $rawProductStock = $ingredient->rawProductStocks()->create($validated);

        return new RawProductStockResource($rawProductStock);
    }
}
