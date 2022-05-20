@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Roles')</div>
            <a href="{{route('admin.roles.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW ROLE')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            <div class="col-md-12">
                @if(count($roles) > 0)
                    <table id="usersTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Display namme')</th>
                            <th>@lang('admin.Name')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->display_name}}</td>
                                <td>{{$role->name}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.roles.edit', ['id' => $role->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.roles.destroy', ['id' => $role->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $roles->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

