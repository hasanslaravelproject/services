<?php

namespace App\Http\Controllers\Api;

use App\Models\MeasureUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MeasureUnitResource;
use App\Http\Resources\MeasureUnitCollection;
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
            ->paginate();

        return new MeasureUnitCollection($measureUnits);
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

        return new MeasureUnitResource($measureUnit);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MeasureUnit $measureUnit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MeasureUnit $measureUnit)
    {
        $this->authorize('view', $measureUnit);

        return new MeasureUnitResource($measureUnit);
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

        return new MeasureUnitResource($measureUnit);
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

        return response()->noContent();
    }
}
