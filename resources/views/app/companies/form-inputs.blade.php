@php $editing = isset($company) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $company->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <!-- <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $company->status : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text> -->
        <label>Status</label> <br>
        <label> 
            <input type="radio" id="status" name="status" value="1" @if(isset($company) && $company->status == 1) checked @endif /> Active
        </label>
        <label> 
            <input type="radio" id="status" name="status" value="0" @if(isset($company) && $company->status == 0) checked @elseif(!isset($company)) checked @endif/> Inactive
        </label>
    </x-inputs.group>
        
    

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="service_id" label="Service">
            @php $selected = old('service_id', ($editing ? $company->service_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Service</option>
            @foreach($services as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>