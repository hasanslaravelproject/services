@php $editing = isset($package) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $package->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="price"
            label="Price"
            value="{{ old('price', ($editing ? $package->price : '')) }}"
            max="255"
            step="0.01"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="validity"
            label="Validity"
            value="{{ old('validity', ($editing ? optional($package->validity)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $package->status : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $package->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="company_id" label="Company">
            @php $selected = old('company_id', ($editing ? $package->company_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Company</option>
            @foreach($companies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="type"
            label="Type"
            value="{{ old('type', ($editing ? $package->type : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>
</div>
