@extends('front.layout')
@section('custom_css')
    <style>
        .noItems{
            text-align: center;
            font-family: Mulish-Light, fantasy;
        }
    </style>
@endsection
@section('content')
    <div class="row cart-container">
        <nav class="breadcrumb-wrapper" style="width: 100%; padding-left: 7%; margin-left: 0;" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Return to store')</a></li>
            </ol>
        </nav>
        <div class="col-lg-10 cart-header">
            <div class="col-lg-12 cart-count">
                @if(Session::has('status'))
                    <h4 class="noItems">@lang('front.An email has been sent, please check your inbox.')</h4>
                @endif
            </div>
        </div>
        <div class="col-lg-7 col-12 cart-items-container">
                <h1 class="noItems">@lang("auth.Before proceeding, please check your email for a verification link.") @lang("auth.If you did not receive the email, click on the button below to request another.")</h1>
            <div class="form-box pt-4 justify-content-center" style="display: flex;">
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-dark">@lang('auth.Send Link')</button>
                </form>
            </div>
            <div class="col-md-12" style="text-align: center; margin-top: 20px">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <a style="text-decoration: none; cursor: pointer; color: #333333;" onclick="this.closest('form').submit()">@lang('front.Sign out')</a><br>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection
