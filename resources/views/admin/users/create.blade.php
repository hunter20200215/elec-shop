@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Users') / @lang('admin.create')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="full_name">@lang('admin.Full name')</label>
                    <input type="text" class="form-control @error('full_name') input-error-danger @enderror" id="full_name" name="full_name" value="{{old('full_name')}}" placeholder="@lang('admin.Full name')">
                    @error('full_name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="email">@lang('admin.Email')</label>
                    <input type="email" class="form-control @error('email') input-error-danger @enderror" id="email" name="email" value="{{old('email')}}" placeholder="@lang('admin.Email')">
                    @error('email') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="password">@lang('admin.Password')</label>
                    <input type="password" class="form-control @error('password') input-error-danger @enderror" id="password" name="password"  placeholder="@lang('admin.Password')">
                    @error('password') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="password_confirmation">@lang('admin.Confirm password')</label>
                    <input type="password" class="form-control @error('password_confirmation') input-error-danger @enderror" id="password_confirmation" name="password_confirmation" placeholder="@lang('admin.Confirm password')">
                    @error('password_confirmation') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="password_confirmation">@lang('admin.Roles')</label>
                    @foreach($roles->chunk(4) as $role_chunk)
                        @foreach($role_chunk as $role)
                            <div class="col-md-6">
                                <div class="pretty p-default">
                                    <input type="checkbox" name="roles[]" value="{{$role->id}}"{{ (old('roles') && in_array($role->id, old('role'))) ? 'checked' : '' }}>
                                    <div class="state p-primary">
                                        <label>{{$role->display_name}}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary" style="position:absolute; bottom:10%">@lang('admin.Save')</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('custom_scripts')
@endsection

