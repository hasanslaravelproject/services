<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Package;
use Stripe\StripeClient;
use App\Models\PackageType;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $role = auth()->user()->roles()->first()->id;
        $user_id = auth()->user()->id;
        if($role ==2){
            $packages = Package::search($search)
            ->latest()
            ->paginate(5);
        }else{
            $packages = Package::join('companies','packages.company_id','companies.id')
            ->join('company_user','companies.id','company_user.company_id')
            ->where('company_user.user_id','=', $user_id)
            ->select('packages.*')
            ->latest()
            ->paginate(5);
        }


        

        return view('app.packages.index', compact('packages', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Package::class);

        //$companies = Company::pluck('name', 'id');
        $user_id = auth()->user()->id;
        
        $companies = Company::join('company_user','companies.id','company_user.company_id')
        ->where('company_user.user_id','=', $user_id)
        ->pluck('companies.name', 'companies.id');
        $packageTypes = PackageType::join('companies','package_types.company_id','companies.id')
        ->join('company_user','companies.id','company_user.company_id')
        ->where('company_user.user_id','=', $user_id)
        ->pluck('package_types.name', 'package_types.id');

        return view(
            'app.packages.create',
            compact('companies', 'packageTypes')
        );
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
        $packageTypes = PackageType::pluck('name', 'id');

        return view(
            'app.packages.edit',
            compact('package', 'companies', 'packageTypes')
        );
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
    public function showPackage(){
        $data['packages']=Package::orderBy('created_at','desc')->get();

        return view('app.packages.show_package',$data);
    }
    public function checkout(Request $request){
        
        $stripeSettings=Setting::where('key','stripe_credentials')->first();
        $data['stripe']=json_decode($stripeSettings->value);

        $data['package']=Package::findOrFail($request->id);
   
        
        return view('app.packages.checkout',$data);
    }
    public function buyPackage(Request $request){
        
        try{
        $stripeSettings=Setting::where('key','stripe_credentials')->first();
        if(!$stripeSettings){
            return abort('404');
        }
        $dataSecretKey=json_decode($stripeSettings->value);
        
        $stripe = new \Stripe\StripeClient($dataSecretKey->stripe_secret_key);
        $package=Package::where('id',$request->package_id)->first();
        
        $stripeResponse = $stripe->charges->create([
            'amount' => (double)$package->price * 100,
            'currency' => 'USD',
            'source' => $request->stripeToken,
            'description' => 'Nullable',
        ]);
       
        
        $userPackage= new UserPackage();
        $userPackage->user_id= auth()->user()->id;
        $userPackage->package_id=$package->id;
        $userPackage->amount=$package->price;
        
        $userPackage->save();
        
        return redirect()->back();
    } catch (\Exception $ex) {
        dd($ex->getMessage());
        return redirect()->back()->withErrors(['fail' => 'There was some problem , try again later']);
    }
    }
}
