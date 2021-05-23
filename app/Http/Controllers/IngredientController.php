<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\MeasureUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5);

        return view('app.ingredients.index', compact('ingredients', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Ingredient::class);

        $measureUnits = MeasureUnit::pluck('name', 'id');

        return view('app.ingredients.create', compact('measureUnits'));
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

        return redirect()
            ->route('ingredients.edit', $ingredient)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ingredient $ingredient)
    {
        $this->authorize('view', $ingredient);

        return view('app.ingredients.show', compact('ingredient'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ingredient $ingredient)
    {
        $this->authorize('update', $ingredient);

        $measureUnits = MeasureUnit::pluck('name', 'id');

        return view(
            'app.ingredients.edit',
            compact('ingredient', 'measureUnits')
        );
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

        return redirect()
            ->route('ingredients.edit', $ingredient)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('ingredients.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
