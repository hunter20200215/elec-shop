@extends('admin.layout')
@section('custom_css')
    <link rel="stylesheet" href="">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">
                @if(!isset($_GET['signups']))
                    @lang('admin.Users')
                @else
                    @lang('admin.SignUPs')
                @endif
            </div>
            @if(!isset($_GET['signups']))
                <a href="{{route('admin.users.create')}}" class="content-header-add-item"><i class="fa fa-plus"></i> @lang('admin.NEW USER')</a>
            @endif
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            {{--<div class="search-field-container">
                <input name="input" class="form-control" style="width:20%" placeholder="Search something">
            </div>--}}
            <div class="col-md-12">
                @if(count($users) > 0)
                    <table id="usersTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th>@lang('admin.ID')</th>
                            <th>@lang('admin.Full name')</th>
                            <th>@lang('admin.Email')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->email}}</td>
                                <td class="buttons-cell">
                                    <a href="{{route('admin.users.edit', ['id' => $user->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    @if(Auth::user()->id != $user->id)<x-delete-button :route="route('admin.users.destroy', ['id' => $user->id])"></x-delete-button>@endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $users->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

    </script>
@endsection

