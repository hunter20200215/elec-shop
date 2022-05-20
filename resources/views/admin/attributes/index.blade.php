@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Attributes')</div>
            <a href="{{route('admin.attributes.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW ATTRIBUTE')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($attributes) > 0)
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Name')</th>
                            <th>@lang('admin.Show on search')</th>
                            <th>@lang('admin.Search type')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributes as $attribute)
                            <tr>
                                <td>{{$attribute->id}}</td>
                                <td>{{$attribute->name}}</td>
                                <td>{{$attribute->show_on_search === 1 ? Lang::get('admin.Yes') : Lang::get('admin.No')}}</td>
                                <td>{{ucfirst($attribute->search_type)}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.attribute_values.index', ['attribute_id' => $attribute->id])}}">
                                        <button type="button" class="btn-sm btn btn-primary" style="margin-right: 5px"> @lang('admin.Values')</button>
                                    </a>
                                    <a href="{{route('admin.attributes.edit', ['id' => $attribute->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.attributes.destroy', ['id' => $attribute->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $attributes->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

