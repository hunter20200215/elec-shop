@extends('admin.layout')
@section('custom_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Permissions') / @lang('admin.edit')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="display_name">@lang('admin.Display name')</label>
                    <input value="{{$permission->display_name}}" type="text" class="form-control @error('display_name') input-error-danger @enderror" id="display_name" name="display_name" placeholder="@lang('admin.Display name')">
                    @error('display_name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Name')</label>
                    <input value="{{$permission->name}}" type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
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

