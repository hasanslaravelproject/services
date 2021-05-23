<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class PackageProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Package $package)
    {
        $this->authorize('view', $package);

        $search = $request->get('search', '');

        $products = $package
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Package $package)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'validity' => ['required', 'max:255', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'barcode' => ['required', 'max:255', 'string'],
        ]);

        $product = $package->products()->create($validated);

        return new ProductResource($product);
    }
}
