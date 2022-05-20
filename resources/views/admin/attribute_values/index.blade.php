@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Attribute values for') {{ $attribute->name }}</div>
            <a href="{{route('admin.attribute_values.create',  ['attribute_id' => $attribute->id])}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW ATTRIBUTE VALUE')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($attribute_values) > 0)
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Value')</th>
                            <th>@lang('admin.Color')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attribute_values as $attribute_value)
                            <tr>
                                <td>{{$attribute_value->id}}</td>
                                <td>{{$attribute_value->value}}</td>
                                <td style="background-color: {{$attribute_value->color}}"></td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.attribute_values.edit', ['attribute_id' => $attribute->id, 'id' => $attribute_value->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.attribute_values.destroy', ['attribute_id' => $attribute->id, 'id' => $attribute_value->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $attribute_values->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

