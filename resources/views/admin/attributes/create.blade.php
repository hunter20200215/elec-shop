@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Attributes') / @lang('admin.create')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Name')</label>
                    <input type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" value="{{old('name')}}" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="show_on_search">@lang('admin.Show on search')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="show_on_search" value="1" checked />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Yes')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="show_on_search" value="0" {{ old('show_on_search') === '0' ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.No')</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="search type">@lang('admin.Search type')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="search_type" value="checkbox" checked />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Checkbox')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="search_type" value="list" {{ old('search_type') === 'list' ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.List')</label>
                            </div>
                        </div>
                    </div>
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

