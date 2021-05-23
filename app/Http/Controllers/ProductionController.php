<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductionStoreRequest;
use App\Http\Requests\ProductionUpdateRequest;

class ProductionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Production::class);

        $search = $request->get('search', '');

        $productions = Production::search($search)
            ->latest()
            ->paginate(5);

        return view('app.productions.index', compact('productions', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Production::class);

        $products = Product::pluck('name', 'id');

        return view('app.productions.create', compact('products'));
    }

    /**
     * @param \App\Http\Requests\ProductionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductionStoreRequest $request)
    {
        $this->authorize('create', Production::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $production = Production::create($validated);

        return redirect()
            ->route('productions.edit', $production)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        return view('app.productions.show', compact('production'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Production $production)
    {
        $this->authorize('update', $production);

        $products = Product::pluck('name', 'id');

        return view('app.productions.edit', compact('production', 'products'));
    }

    /**
     * @param \App\Http\Requests\ProductionUpdateRequest $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductionUpdateRequest $request,
        Production $production
    ) {
        $this->authorize('update', $production);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($production->image) {
                Storage::delete($production->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $production->update($validated);

        return redirect()
            ->route('productions.edit', $production)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Production $production)
    {
        $this->authorize('delete', $production);

        if ($production->image) {
            Storage::delete($production->image);
        }

        $production->delete();

        return redirect()
            ->route('productions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
