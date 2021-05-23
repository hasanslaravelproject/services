<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Company;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.packages.index', compact('packages', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Package::class);

        $companies = Company::pluck('name', 'id');

        return view('app.packages.create', compact('companies'));
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

        return redirect()
            ->route('packages.edit', $package)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Package $package)
    {
        $this->authorize('view', $package);

        return view('app.packages.show', compact('package'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $companies = Company::pluck('name', 'id');

        return view('app.packages.edit', compact('package', 'companies'));
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

        return redirect()
            ->route('packages.edit', $package)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
