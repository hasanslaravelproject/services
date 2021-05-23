@php $editing = isset($finishedProductStock) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="quantity"
            label="Quantity"
            value="{{ old('quantity', ($editing ? $finishedProductStock->quantity : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="validity"
            label="Validity"
            value="{{ old('validity', ($editing ? $finishedProductStock->validity : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="finished_product_stock_id"
            label="Finished Product Stock"
        >
            @php $selected = old('finished_product_stock_id', ($editing ? $finishedProductStock->finished_product_stock_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Finished Product Stock</option>
            @foreach($finishedProductStocks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="production_id" label="Production">
            @php $selected = old('production_id', ($editing ? $finishedProductStock->production_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Production</option>
            @foreach($productions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
