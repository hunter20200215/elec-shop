@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Users') / @lang('admin.edit')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Full name')</label>
                    <input value="{{$role->name}}" type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="display_name">@lang('admin.Display name')</label>
                    <input value="{{$role->display_name}}" type="text" class="form-control @error('display_name') input-error-danger @enderror" id="display_name" name="display_name" placeholder="@lang('admin.Display name')">
                    @error('display_name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="permissions">@lang('admin.Permissions')</label>
                    @foreach($permissions->chunk(4) as $permission_chunk)
                        @foreach($permission_chunk as $permission)
                            <div class="col-md-6">
                                <div class="pretty p-default">
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{ (in_array($permission->id, $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <div class="state p-primary">
                                        <label>{{$permission->display_name}}</label>
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

