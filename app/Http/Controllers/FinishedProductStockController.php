<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\FinishedProductStock;
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
            ->paginate(5);

        return view(
            'app.finished_product_stocks.index',
            compact('finishedProductStocks', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', FinishedProductStock::class);

        $finishedProductStocks = FinishedProductStock::pluck('validity', 'id');
        $productions = Production::pluck('name', 'id');

        return view(
            'app.finished_product_stocks.create',
            compact('finishedProductStocks', 'productions')
        );
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

        return redirect()
            ->route('finished-product-stocks.edit', $finishedProductStock)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'app.finished_product_stocks.show',
            compact('finishedProductStock')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FinishedProductStock $finishedProductStock
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        FinishedProductStock $finishedProductStock
    ) {
        $this->authorize('update', $finishedProductStock);

        $finishedProductStocks = FinishedProductStock::pluck('validity', 'id');
        $productions = Production::pluck('name', 'id');

        return view(
            'app.finished_product_stocks.edit',
            compact(
                'finishedProductStock',
                'finishedProductStocks',
                'productions'
            )
        );
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

        return redirect()
            ->route('finished-product-stocks.edit', $finishedProductStock)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('finished-product-stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
