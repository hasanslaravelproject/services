@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('finished-product-stocks.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.finished_product_stocks.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.finished_product_stocks.inputs.quantity')
                    </h5>
                    <span>{{ $finishedProductStock->quantity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.finished_product_stocks.inputs.validity')
                    </h5>
                    <span>{{ $finishedProductStock->validity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.finished_product_stocks.inputs.finished_product_stock_id')
                    </h5>
                    <span
                        >{{
                        optional($finishedProductStock->finishedProductStock)->validity
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.finished_product_stocks.inputs.production_id')
                    </h5>
                    <span
                        >{{ optional($finishedProductStock->production)->name ??
                        '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('finished-product-stocks.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FinishedProductStock::class)
                <a
                    href="{{ route('finished-product-stocks.create') }}"
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
