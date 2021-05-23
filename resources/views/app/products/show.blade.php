@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('products.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.products.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.name')</h5>
                    <span>{{ $product->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.price')</h5>
                    <span>{{ $product->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.validity')</h5>
                    <span>{{ $product->validity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.package_id')</h5>
                    <span>{{ optional($product->package)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.category_id')</h5>
                    <span>{{ optional($product->category)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.products.inputs.barcode')</h5>
                    <span>{{ $product->barcode ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Product::class)
                <a href="{{ route('products.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
