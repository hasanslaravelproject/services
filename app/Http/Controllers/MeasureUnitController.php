<?php

namespace App\Http\Controllers;

use App\Models\MeasureUnit;
use Illuminate\Http\Request;
use App\Http\Requests\MeasureUnitStoreRequest;
use App\Http\Requests\MeasureUnitUpdateRequest;

class MeasureUnitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MeasureUnit::class);

        $search = $request->get('search', '');

        $measureUnits = MeasureUnit::search($search)
            ->latest()
            ->paginate(5);

        return view(
            'app.measure_units.index',
            compact('measureUnits', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', MeasureUnit::class);

        return view('app.measure_units.create');
    }

    /**
     * @param \App\Http\Requests\MeasureUnitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeasureUnitStoreRequest $request)
    {
        $this->authorize('create', MeasureUnit::class);

        $validated = $request->validated();

        $measureUnit = MeasureUnit::create($validated);

        return redirect()
            ->route('measure-units.edit', $measureUnit)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('view', $measureUnit);

        return view('app.measure_units.show', compact('measureUnit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('update', $measureUnit);

        return view('app.measure_units.edit', compact('measureUnit'));
    }

    /**
     * @param \App\Http\Requests\MeasureUnitUpdateRequest $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function update(
        MeasureUnitUpdateRequest $request,
        MeasureUnit $measureUnit
    ) {
        $this->authorize('update', $measureUnit);

        $validated = $request->validated();

        $measureUnit->update($validated);

        return redirect()
            ->route('measure-units.edit', $measureUnit)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('delete', $measureUnit);

        $measureUnit->delete();

        return redirect()
            ->route('measure-units.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
