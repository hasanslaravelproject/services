<?php

namespace App\Http\Controllers\Api;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\IngredientResource;
use App\Http\Resources\IngredientCollection;
use App\Http\Requests\IngredientStoreRequest;
use App\Http\Requests\IngredientUpdateRequest;

class IngredientController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Ingredient::class);

        $search = $request->get('search', '');

        $ingredients = Ingredient::search($search)
            ->latest()
            ->paginate();

        return new IngredientCollection($ingredients);
    }

    /**
     * @param \App\Http\Requests\IngredientStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientStoreRequest $request)
    {
        $this->authorize('create', Ingredient::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $ingredient = Ingredient::create($validated);

        return new IngredientResource($ingredient);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ingredient $ingredient)
    {
        $this->authorize('view', $ingredient);

        return new IngredientResource($ingredient);
    }

    /**
     * @param \App\Http\Requests\IngredientUpdateRequest $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(
        IngredientUpdateRequest $request,
        Ingredient $ingredient
    ) {
        $this->authorize('update', $ingredient);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($ingredient->image) {
                Storage::delete($ingredient->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $ingredient->update($validated);

        return new IngredientResource($ingredient);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ingredient $ingredient)
    {
        $this->authorize('delete', $ingredient);

        if ($ingredient->image) {
            Storage::delete($ingredient->image);
        }

        $ingredient->delete();

        return response()->noContent();
    }
}
