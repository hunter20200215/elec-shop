@extends('front.layout')
@section('custom_css')
    <style>
        .my-account-options{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding:25px;
        }
        .my-account-option-text{
            color: #8d8d8d;
        }
        .form-group{
            margin-bottom: 1rem;
        }
        .my-profile-content-container{
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
        .custom-hr{
            width: 0;
            display: none;
        }
        .my-account-option{
            margin-bottom:10px;
        }
        .my-account-option-text{
            font-size: 15pt;
        }
        @media(max-width: 767px){
            .custom-hr{
                width: 100%;
                display: block;
            }
            .my-profile-content-container{
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div class="col-12 my-profile-content-container" style="">
            <div class="col-12 col-md-4 col-lg-2" style="" class="my-account-options">
                <div class="my-account-option">
                    <a class="my-account-option-text active-link" href="{{route('my_account')}}">
                        @lang('front.My account')
                    </a>
                </div>
                <div class="my-account-option">
                    <a class="my-account-option-text" href="{{route('my_orders')}}">
                        @lang('front.My orders')
                    </a>
                </div>
                @if($user->unsubscribed == 0)
                    <div class="my-account-option">
                        <a class="my-account-option-text" href="{{route('unsubscribe')}}">
                            @lang('front.Unsubscribe')
                        </a>
                    </div>
                @endif
                @if($user->hasRole('admin'))
                    <div class="my-account-option">
                        <a class="my-account-option-text" href="{{route('admin.dashboard')}}">
                            @lang('front.Administration')
                        </a>
                    </div>
                @endif
                <div class="my-account-option">
                    <a class="my-account-option-text" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
            document.getElementById('logout-form-front').submit();">
                        <div class="navbar-item-text">{{ __('Logout') }}</div>
                    </a>
                    <form id="logout-form-front" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <hr class="custom-hr"/>
            <div class="col-12 col-md-6 col-lg-5" style="">
                <form method="POST" action="{{route('update_my_account')}}" >
                    @csrf
                    <div class="form-group">
                        <label for="full_name">@lang('front.Full name')</label>
                        <input type="text" class="form-control @error('full_name') input-error-danger @enderror" id="full_name" name="full_name" placeholder="@lang('Enter full name')" value="{{$user->full_name}}">
                        @error('full_name') <span style="color:red">{{$message}}</span>@enderror

                    </div>
                    <div class="form-group">
                        <label for="email">@lang('front.Email')</label>
                        <input type="email" class="form-control @error('email') input-error-danger @enderror" name="email" id="email" placeholder="@lang('front.Enter email')"  aria-describedby="emailHelp" value="{{$user->email}}">
                        <small id="emailHelp" class="form-text text-muted">@lang('We will never share your email with anyone else.')</small>
                        @error('email') <span style="color:red">{{$message}}</span>@enderror

                    </div>
                    <hr/>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('front.Password')</label>
                        <input type="password" class="form-control @error('password') input-error-danger @enderror" name="password" placeholder="@lang('front.Password')">
                        @error('password') <span style="color:red">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('front.Password confirmation')</label>
                        <input type="password" class="form-control @error('value') input-error-danger @enderror" name="password_confirmation"  placeholder="@lang('front.Password confirmation')">
                    </div>
                    <button type="submit" class="btn btn-primary btn-dark" style="border-radius: 10px">@lang('front.Save')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

