<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Resources\PackageCollection;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;

class PackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Package::class);

        $search = $request->get('search', '');

        $packages = Package::search($search)
            ->latest()
            ->paginate();

        return new PackageCollection($packages);
    }

    /**
     * @param \App\Http\Requests\PackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageStoreRequest $request)
    {
        $this->authorize('create', Package::class);

        $validated = $request->validated();

        $package = Package::create($validated);

        return new PackageResource($package);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Package $package)
    {
        $this->authorize('view', $package);

        return new PackageResource($package);
    }

    /**
     * @param \App\Http\Requests\PackageUpdateRequest $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function update(PackageUpdateRequest $request, Package $package)
    {
        $this->authorize('update', $package);

        $validated = $request->validated();

        $package->update($validated);

        return new PackageResource($package);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Package $package)
    {
        $this->authorize('delete', $package);

        $package->delete();

        return response()->noContent();
    }
}
