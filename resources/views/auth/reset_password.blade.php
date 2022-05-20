@extends('front.layout')
@section('custom_css')
    <style>
        body{
            min-height: 100vh;
        }
    </style>
@endsection
@section('content')
    <div class="auth-container">
        <div class="auth-item">
            <div class="auth-header-container">
                <div class="auth-header-text">
                    <h3>@lang('front.Reset password')</h3>
                </div>
                <div class="auth-header-subtext">
                    @lang('front.Type in new password')
                </div>
            </div>
            <div class="auth-card">
                <form class="auth-form" method="POST" action="{{route('password.update')}}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email">@lang('admin.Email')</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') input-error-danger @enderror" id="email" name="email" placeholder="@lang('admin.Email')" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                            </div>
                            @error('email') <span style="color:red; width:100%;">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('admin.Password')</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') input-error-danger @enderror" id="password" name="password" placeholder="@lang('admin.Password')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                            </div>
                            @error('password') <span style="color:red; width:100%;">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">@lang('admin.Confirm password')</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password_confirmation') input-error-danger @enderror" id="password_confirmation" name="password_confirmation" placeholder="@lang('admin.Confirm password')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                            </div>
                            @error('password_confirmation') <span style="width:100%; color:red">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: row;  justify-content: flex-end">
                        <button type="submit" class="btn btn-dark btn-starwars">@lang('admin.Reset password')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

