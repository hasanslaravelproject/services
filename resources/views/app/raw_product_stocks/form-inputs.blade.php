@php $editing = isset($rawProductStock) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="quantity"
            label="Quantity"
            value="{{ old('quantity', ($editing ? $rawProductStock->quantity : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="expiry_date"
            label="Expiry Date"
            value="{{ old('expiry_date', ($editing ? optional($rawProductStock->expiry_date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="ingredient_id" label="Ingredient">
            @php $selected = old('ingredient_id', ($editing ? $rawProductStock->ingredient_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Ingredient</option>
            @foreach($ingredients as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
