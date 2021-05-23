<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;

class ServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Service::class);

        $search = $request->get('search', '');
        $role = auth()->user()->roles()->first()->id;
        $user_id = auth()->user()->id;
        
        if($role == 2){
            $services = Service::search($search)
            ->latest()
            ->paginate(5);
        }else{
            $services = Service::join('companies','services.id','companies.service_id')
            ->join('company_user','companies.id','company_user.company_id')
            ->where('company_user.user_id','=', $user_id)
            ->paginate(5);
        }
        
        return view('app.services.index', compact('services', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Service::class);

        return view('app.services.create');
    }

    /**
     * @param \App\Http\Requests\ServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $this->authorize('create', Service::class);

        $validated = $request->validated();

        $service = Service::create($validated);

        return redirect()
            ->route('services.edit', $service)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Service $service)
    {
        $this->authorize('view', $service);

        return view('app.services.show', compact('service'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        return view('app.services.edit', compact('service'));
    }

    /**
     * @param \App\Http\Requests\ServiceUpdateRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $this->authorize('update', $service);

        $validated = $request->validated();

        $service->update($validated);

        return redirect()
            ->route('services.edit', $service)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()
            ->route('services.index')
            ->withSuccess(__('crud.common.removed'));
    }
}