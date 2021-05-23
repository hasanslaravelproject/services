<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;

class ServiceCompaniesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $service)
    {
        $this->authorize('view', $service);

        $search = $request->get('search', '');

        $companies = $service
            ->companies()
            ->search($search)
            ->latest()
            ->paginate();

        return new CompanyCollection($companies);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Service $service)
    {
        $this->authorize('create', Company::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
        ]);

        $company = $service->companies()->create($validated);

        return new CompanyResource($company);
    }
}
