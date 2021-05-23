@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('ingredients.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.ingredients.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.ingredients.inputs.name')</h5>
                    <span>{{ $ingredient->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ingredients.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $ingredient->image ? \Storage::url($ingredient->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ingredients.inputs.measure_unit_id')</h5>
                    <span
                        >{{ optional($ingredient->measureUnit)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('ingredients.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Ingredient::class)
                <a
                    href="{{ route('ingredients.create') }}"
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
