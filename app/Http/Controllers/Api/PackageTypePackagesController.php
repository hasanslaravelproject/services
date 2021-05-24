<?php

namespace App\Http\Controllers\Api;

use App\Models\PackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Resources\PackageCollection;

class PackageTypePackagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PackageType $packageType)
    {
        $this->authorize('view', $packageType);

        $search = $request->get('search', '');

        $packages = $packageType
            ->packages()
            ->search($search)
            ->latest()
            ->paginate();

        return new PackageCollection($packages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PackageType $packageType)
    {
        $this->authorize('create', Package::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'validity' => ['required', 'date', 'date'],
            'status' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'company_id' => ['nullable', 'exists:companies,id'],
        ]);

        $package = $packageType->packages()->create($validated);

        return new PackageResource($package);
    }
}
