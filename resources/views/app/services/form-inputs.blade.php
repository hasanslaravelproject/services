@php $editing = isset($service) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $service->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <!--<x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $service->status : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>-->
        <label>Status</label> <br>
        <label> 
            <input type="radio" id="status" name="status" value="1" @if(isset($service) && $service->status == 1) checked @endif /> Active
        </label>
        <label> 
            <input type="radio" id="status" name="status" value="0" @if(isset($service) && $service->status == 0) checked @elseif(!isset($service)) checked @endif/> Inactive
        </label>
    </x-inputs.group>
</div>
