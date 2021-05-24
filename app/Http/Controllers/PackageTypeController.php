<?php

namespace App\Http\Controllers;

use App\Models\PackageType;
use Illuminate\Http\Request;
use App\Http\Requests\PackageTypeStoreRequest;
use App\Http\Requests\PackageTypeUpdateRequest;
use App\Models\Company;

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
        $role = auth()->user()->roles()->first()->id;
        $user_id = auth()->user()->id;
        if($role ==2){
            $packageTypes = PackageType::search($search)
            ->latest()
            ->paginate(5);
        }else{
            $packageTypes = PackageType::join('companies','package_types.company_id','companies.id')
            ->join('company_user','companies.id','company_user.company_id')
            ->where('company_user.user_id','=', $user_id)
            ->select('package_types.*')
            ->latest()
            ->paginate(5);
        }

        
        $companies = Company::get();
                
        return view(
            'app.package_types.index',
            compact('packageTypes', 'search', 'companies')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', PackageType::class);
        $user_id = auth()->user()->id;
        
        $companies = Company::join('company_user','companies.id','company_user.company_id')
        ->where('company_user.user_id','=', $user_id)
        ->get();
        
        return view('app.package_types.create', compact('companies'));
    }

    /**
     * @param \App\Http\Requests\PackageTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageTypeStoreRequest $request)
    {
        $this->authorize('create', PackageType::class);
        
        $validated = $request->all();

        $packageType = PackageType::create($validated);

        return redirect()
            ->route('package-types.edit', $packageType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PackageType $packageType)
    {
        $this->authorize('view', $packageType);

        return view('app.package_types.show', compact('packageType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PackageType $packageType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PackageType $packageType)
    {
        $this->authorize('update', $packageType);
        $user_id = auth()->user()->id;
        
        $companies = Company::join('company_user','companies.id','company_user.company_id')
        ->where('company_user.user_id','=', $user_id)
        ->get();
        
        return view('app.package_types.edit', compact('packageType','companies'));
        
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

        $validated = $request->all();

        $packageType->update($validated);

        return redirect()
            ->route('package-types.edit', $packageType)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('package-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
