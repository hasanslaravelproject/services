@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('productions.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.productions.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.name')</h5>
                    <span>{{ $production->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.date')</h5>
                    <span>{{ $production->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.validity')</h5>
                    <span>{{ $production->validity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $production->image ? \Storage::url($production->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.quanity')</h5>
                    <span>{{ $production->quanity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.price')</h5>
                    <span>{{ $production->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.order_id')</h5>
                    <span>{{ $production->order_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.productions.inputs.product_id')</h5>
                    <span
                        >{{ optional($production->product)->name ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('productions.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Production::class)
                <a
                    href="{{ route('productions.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
