<?php

namespace App\Http\Controllers\Api;

use App\Models\MeasureUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Http\Resources\IngredientCollection;

class MeasureUnitIngredientsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('view', $measureUnit);

        $search = $request->get('search', '');

        $ingredients = $measureUnit
            ->ingredients()
            ->search($search)
            ->latest()
            ->paginate();

        return new IngredientCollection($ingredients);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('create', Ingredient::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $ingredient = $measureUnit->ingredients()->create($validated);

        return new IngredientResource($ingredient);
    }
}
