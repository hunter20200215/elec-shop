@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Categories')</div>
            <a href="{{route('admin.categories.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW CATEGORY')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($categories) > 0)
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Name')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.categories.edit', ['id' => $category->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.categories.destroy', ['id' => $category->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $categories->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

