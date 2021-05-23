<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class IngredientProductsController extends Controller
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

        $products = $ingredient
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Ingredient $ingredient,
        Product $product
    ) {
        $this->authorize('update', $ingredient);

        $ingredient->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Ingredient $ingredient,
        Product $product
    ) {
        $this->authorize('update', $ingredient);

        $ingredient->products()->detach($product);

        return response()->noContent();
    }
}
