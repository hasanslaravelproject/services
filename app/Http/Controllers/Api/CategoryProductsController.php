<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class CategoryProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $products = $category
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'validity' => ['required', 'max:255', 'string'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'barcode' => ['required', 'max:255', 'string'],
        ]);

        $product = $category->products()->create($validated);

        return new ProductResource($product);
    }
}
