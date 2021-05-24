<?php

namespace App\Http\Controllers\Api;

use App\Models\PackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageTypeResource;
use App\Http\Resources\PackageTypeCollection;
use App\Http\Requests\PackageTypeStoreRequest;
use App\Http\Requests\PackageTypeUpdateRequest;

class PackageTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PackageType::class);

        $search = $request->get('search', '');

        $packageTypes = PackageType::search($search)
            ->latest()
            ->paginate();

        return new PackageTypeCollection($packageTypes);
    }

    /**
     * @param \App\Http\Requests\PackageTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageTypeStoreRequest $request)
    {
        $this->authorize('create', PackageType::class);

        $validated = $request->validated();

        $packageType = PackageType::create($validated);

        return new PackageTypeResource($packageType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PackageType $packageType)
    {
        $this->authorize('view', $packageType);

        return new PackageTypeResource($packageType);
    }

    /**
     * @param \App\Http\Requests\PackageTypeUpdateRequest $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function update(
        PackageTypeUpdateRequest $request,
        PackageType $packageType
    ) {
        $this->authorize('update', $packageType);

        $validated = $request->validated();

        $packageType->update($validated);

        return new PackageTypeResource($packageType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PackageType $packageType)
    {
        $this->authorize('delete', $packageType);

        $packageType->delete();

        return response()->noContent();
    }
}
