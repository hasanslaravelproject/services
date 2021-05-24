<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use DB;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);
        
        $search = $request->get('search', '');
        
        $users = User::search($search)
            ->latest()
            ->paginate(5);
        
        return view('app.users.index', compact('users', 'search'));
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $role = auth()->user()->roles()->first()->id;
        $this->authorize('create', User::class);
        
        $roles = Role::get();
        if($role == 2){
            $companies = Company::get();
        }else{
            $companies =[];
        }

        return view('app.users.create', compact('roles','companies'));
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $user = User::create($validated);
        
        $user->syncRoles($request->roles);

        $role = auth()->user()->roles()->first()->id;
        
        $user_id = User::orderBy('id','DESC')->first();
        $roles = Role::get();
        if($role == 2 && $request->company != ''){
            $companies = $request->company;
            foreach($companies as $company){
                $insert_company = new CompanyUser();
                $insert_company->user_id = $user_id->id;
                $insert_company->company_id = $company;
                $insert_company->save();
            }
            
        }

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $role = auth()->user()->roles()->first()->id;
        $this->authorize('update', $user);
        
        $roles = Role::get();
        if($role == 2){
            $companies = Company::get();
            $company_user = CompanyUser::join('users','users.id','company_user.user_id')
                                        ->where('users.id','=',$user->id)
                                        ->pluck('company_user.company_id')
                                        ->toArray();
        }else{
            $companies =[];
            $company_user = [];
        }
        

        return view('app.users.edit', compact('user', 'roles','companies','company_user'));
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();
        
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $user->update($validated);

        $user->syncRoles($request->roles);
        
        $role = auth()->user()->roles()->first()->id;
        
        CompanyUser::where('user_id','=',$user->id)->delete(); // delete previous company of this user
        if($role == 2 && $request->company != ''){
            $companies = $request->company;
        
            foreach($companies as $company){
                $insert_company = new CompanyUser();
                $insert_company->user_id = $user->id;
                $insert_company->company_id = $company;
                $insert_company->save();
            }
            
        }

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        if ($user->image) {
            Storage::delete($user->image);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}