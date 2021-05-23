<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Http\Resources\ProductionCollection;

class ProductProductionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productions = $product
            ->productions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', Production::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date', 'date'],
            'validity' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
            'quanity' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'order_id' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $production = $product->productions()->create($validated);

        return new ProductionResource($production);
    }
}
