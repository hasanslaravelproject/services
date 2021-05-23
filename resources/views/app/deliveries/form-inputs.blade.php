@php $editing = isset($delivery) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="quantity"
            label="Quantity"
            value="{{ old('quantity', ($editing ? $delivery->quantity : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="production_id" label="Production">
            @php $selected = old('production_id', ($editing ? $delivery->production_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Production</option>
            @foreach($productions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="order_id" label="Order">
            @php $selected = old('order_id', ($editing ? $delivery->order_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Order</option>
            @foreach($orders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
