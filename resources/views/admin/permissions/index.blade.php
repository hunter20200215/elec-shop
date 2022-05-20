@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Permissions')</div>
            <a href="{{route('admin.permissions.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW PERMISSION')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($permissions) > 0)
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Display name')</th>
                            <th>@lang('admin.Name')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->display_name}}</td>
                                <td>{{$permission->name}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.permissions.edit', ['id' => $permission->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.permissions.destroy', ['id' => $permission->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $permissions->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

