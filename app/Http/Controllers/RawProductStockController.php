<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\RawProductStock;
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
            ->paginate(5);

        return view(
            'app.raw_product_stocks.index',
            compact('rawProductStocks', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', RawProductStock::class);

        $ingredients = Ingredient::pluck('name', 'id');

        return view('app.raw_product_stocks.create', compact('ingredients'));
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

        return redirect()
            ->route('raw-product-stocks.edit', $rawProductStock)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RawProductStock $rawProductStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RawProductStock $rawProductStock)
    {
        $this->authorize('view', $rawProductStock);

        return view('app.raw_product_stocks.show', compact('rawProductStock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RawProductStock $rawProductStock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RawProductStock $rawProductStock)
    {
        $this->authorize('update', $rawProductStock);

        $ingredients = Ingredient::pluck('name', 'id');

        return view(
            'app.raw_product_stocks.edit',
            compact('rawProductStock', 'ingredients')
        );
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

        return redirect()
            ->route('raw-product-stocks.edit', $rawProductStock)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('raw-product-stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
