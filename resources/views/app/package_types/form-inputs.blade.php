@php $editing = isset($packageType) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $packageType->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
    
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="company_id" label="Company">
            <option value="">Please select the Company</option>
            @foreach($companies as $value => $company)
            <option value="{{ $company->id }}" @if(isset($packageType->id) && $packageType->company_id == $company->id) selected @endif>{{ $company->name }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
