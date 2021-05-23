<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Resources\PackageCollection;

class CompanyPackagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $packages = $company
            ->packages()
            ->search($search)
            ->latest()
            ->paginate();

        return new PackageCollection($packages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', Package::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'validity' => ['required', 'date', 'date'],
            'status' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'type' => ['nullable', 'max:255', 'string'],
        ]);

        $package = $company->packages()->create($validated);

        return new PackageResource($package);
    }
}
