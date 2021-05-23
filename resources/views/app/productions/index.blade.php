@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.productions.index_title')
                </h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\Production::class)
                        <a
                            href="{{ route('productions.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.productions.inputs.name')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.date')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.validity')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.image')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.quanity')
                            </th>
                            <th class="text-right">
                                @lang('crud.productions.inputs.price')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.order_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.productions.inputs.product_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productions as $production)
                        <tr>
                            <td>{{ $production->name ?? '-' }}</td>
                            <td>{{ $production->date ?? '-' }}</td>
                            <td>{{ $production->validity ?? '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $production->image ? \Storage::url($production->image) : '' }}"
                                />
                            </td>
                            <td>{{ $production->quanity ?? '-' }}</td>
                            <td>{{ $production->price ?? '-' }}</td>
                            <td>{{ $production->order_id ?? '-' }}</td>
                            <td>
                                {{ optional($production->product)->name ?? '-'
                                }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $production)
                                    <a
                                        href="{{ route('productions.edit', $production) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $production)
                                    <a
                                        href="{{ route('productions.show', $production) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $production)
                                    <form
                                        action="{{ route('productions.destroy', $production) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">{!! $productions->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
