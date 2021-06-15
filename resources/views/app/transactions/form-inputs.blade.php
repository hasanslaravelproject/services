@php $editing = isset($transaction) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($transaction->date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>
</div>
