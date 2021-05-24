@if(auth()->user()->roles()->first()->id == 2)
    <div class="form-group col-sm-12 mt-4">
        <h4>Assign Company</h4>
        
        @foreach ($companies as $company)
        <div>
        <label>
            <input type="checkbox"
                id="company{{ $company->id }}"
                name="company[]"
                label="{{ ucfirst($company->name) }}"
                value="{{ $company->id }}"
                @if(isset($company_user) && in_array($company->id, $company_user)) checked @endif
            /> 
            {{ $company->name }}</label>
        </div>
        @endforeach
    </div>
    @endif
    
    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.roles.name')</h4>
        
        @foreach ($roles as $role)
        <div>
            <x-inputs.checkbox
                id="role{{ $role->id }}"
                name="roles[]"
                label="{{ ucfirst($role->name) }}"
                value="{{ $role->id }}"
                :checked="isset($user) ? $user->hasRole($role) : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>


    <label>Status</label> <br>
        <label> 
            <input type="radio" id="status" name="status" value="1" @if(isset($user) && $user->status == 1) checked @endif /> Active
        </label>
        <label> 
            <input type="radio" id="status" name="status" value="0" @if(isset($user) && $user->status == 0) checked @elseif(!isset($user)) checked @endif/> Inactive
        </label>
    </x-inputs.group>

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