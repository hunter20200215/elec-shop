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
                    <h3>@lang('front.Forgot password?')</h3>
                </div>
                <div class="auth-header-subtext">
                    @lang('front.Enter your email')
                </div>
            </div>
            <div class="auth-card">
                <form class="auth-form" method="POST" action="{{route('password.email')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">@lang('admin.Email')</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') input-error-danger @enderror" id="email" name="email" placeholder="@lang('admin.Email')" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                            </div>
                            @error('email') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: row;  justify-content: center">
                        <button type="submit" class="btn btn-dark" style="width:80%" id="loginButton">@lang('admin.Reset password')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

