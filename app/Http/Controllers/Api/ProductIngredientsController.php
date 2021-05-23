<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientCollection;

class ProductIngredientsController extends Controller
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

        $ingredients = $product
            ->ingredients()
            ->search($search)
            ->latest()
            ->paginate();

        return new IngredientCollection($ingredients);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Ingredient $ingredient
    ) {
        $this->authorize('update', $product);

        $product->ingredients()->syncWithoutDetaching([$ingredient->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        Ingredient $ingredient
    ) {
        $this->authorize('update', $product);

        $product->ingredients()->detach($ingredient);

        return response()->noContent();
    }
}
