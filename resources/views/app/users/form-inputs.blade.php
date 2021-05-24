@php $editing = isset($user) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $user->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email
            name="email"
            label="Email"
            value="{{ old('email', ($editing ? $user->email : '')) }}"
            maxlength="255"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $user->image ? \Storage::url($user->image) : '' }}')"
        >
            <x-inputs.partials.label
                name="image"
                label="Image"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>
            
            <div class="mt-2">
                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>
            
            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
    
    <x-inputs.group class="col-sm-12">
        <!-- <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $user->status : '')) }}"
            maxlength="255"
        ></x-inputs.text> -->
        <label>Status</label> <br>
        <label> 
            <input type="radio" id="status" name="status" value="1" @if(isset($user) && $user->status == 1) checked @endif /> Active
        </label>
        <label> 
            <input type="radio" id="status" name="status" value="0" @if(isset($user) && $user->status == 0) checked @elseif(!isset($user)) checked @endif/> Inactive
        </label>
    </x-inputs.group>
    
    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="validity"
            label="Validity"
            value="{{ old('validity', ($editing ? optional($user->validity)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>
    
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
</div>