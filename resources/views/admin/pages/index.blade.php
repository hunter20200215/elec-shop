@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Pages')</div>
            <a href="{{route('admin.pages.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW PAGE')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($pages) > 0)
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Title')</th>
                            <th>@lang('admin.Status')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{$page->id}}</td>
                                <td>{{$page->title}}</td>
                                <td>{{$page->status === 1 ? Lang::get('admin.Activated') : Lang::get('admin.Deactivated')}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.pages.edit', ['page' => $page->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.pages.destroy', ['page' => $page->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $pages->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

