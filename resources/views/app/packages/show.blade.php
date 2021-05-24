@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('packages.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.packages.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.name')</h5>
                    <span>{{ $package->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.price')</h5>
                    <span>{{ $package->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.validity')</h5>
                    <span>{{ $package->validity ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.status')</h5>
                    <span>{{ $package->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.description')</h5>
                    <span>{{ $package->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.company_id')</h5>
                    <span>{{ optional($package->company)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.packages.inputs.package_type_id')</h5>
                    <span
                        >{{ optional($package->packageType)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('packages.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Package::class)
                <a href="{{ route('packages.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
