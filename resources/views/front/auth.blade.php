@extends('front.layout')
@section('custom_css')
    <style>
        body{
            min-height: 100vh;
        }
    </style>
@endsection
@section('content')
    @if(isset($_GET['postCart']))
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:20px; justify-self: center;align-self: center;" role="alert">
            <strong>@lang('admin.Success!')</strong> @lang('front.In order to continue, please create an account.')
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="auth-container">
        <div class="auth-item">
            <div class="auth-header-container">
                <div class="auth-header-text">
                    <h3>@lang('front.Welcome Back!')</h3>
                </div>
                <div class="auth-header-subtext">
                    @lang('front.Sign in to your Genesis Bricks Account')
                </div>
            </div>
            <div class="auth-card">
                <form class="auth-form" method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">@lang('admin.Email')</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') input-error-danger @enderror" name="email" placeholder="@lang('admin.Email')" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                            </div>
                            @error('email') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('admin.Password')</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') input-error-danger @enderror" name="password" placeholder="@lang('admin.Password')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                            </div>
                            @error('password') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: row;  justify-content: center">
                        <button type="button" class="btn btn-dark" onclick="submitForm(this)" style="width:80%">@lang('admin.Sign in')</button>
                    </div>
                    <div class="auth-form-footer">
                        <a href="{{route('password.request')}}">@lang("admin.Can't log in?")</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="auth-item">
            <div class="auth-header-container">
                <div class="auth-header-text">
                    <h3>@lang('front.Not a Member Yet?')</h3>
                </div>
                <div class="auth-header-subtext">
                    @lang('front.Sign up to Complete Checkout')
                </div>
            </div>

            <div class="auth-card">
                <form class="auth-form" method="POST" action="{{route('register')}}">
                    @csrf
                    <div class="form-group" >
                        <label for="full_name">@lang('admin.Full name')</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('full_name') input-error-danger @enderror" name="full_name" placeholder="@lang('admin.Full name')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                            </div>
                            @error('full_name') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('admin.Email')</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email', 'register') input-error-danger @enderror" name="email" placeholder="@lang('admin.Email')" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                            </div>
                            @error('email', 'register') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('admin.Password')</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password', 'register') input-error-danger @enderror" name="password" placeholder="@lang('admin.Password')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                            </div>
                            @error('password', 'register') <span style="color:red; width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">@lang('admin.Confirm password')</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password_confirmation') input-error-danger @enderror" name="password_confirmation" placeholder="@lang('admin.Confirm password')">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                            </div>
                            @error('password_confirmation') <span style="color:red;width:100%">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: row;  justify-content: flex-end">
                        <button type="button" class="btn btn-dark btn-starwars" onclick="submitForm(this)">@lang('admin.Register')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script>
        const submitForm = (_this) => {
            if(localStorage.getItem('products')){
                let input = document.createElement('input');
                input.value = localStorage.getItem('products');
                input.type = 'hidden';
                input.name = 'products';
                _this.closest('form').appendChild(input);
            }
            _this.closest('form').submit();
        }
    </script>
@endsection

