@extends('front.layout')
@section('custom_css')
    <style>
        body{
            min-height: 100vh;
        }
        .page-container{
            background-image: url('{{asset('images/contact_page_background.jpg')}}');
        }
        .contact-content-container{
            background-color: rgba(255, 255, 255, 0.7);
            width: 750px;
            min-height:826px;
            padding:50px;
        }
        .contact-us-header{
            font-family: DroidSerif, sans-serif
        }
        @media(max-width: 767px){
            .page-container{
                padding:20px 5px;
                background-size: cover;
            }
            .contact-content-container{

                width: auto;
                min-height:826px;
                padding:10px 10px;
            }
            .contact-us-header{
                font-size: 20px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div class="offset-lg-2 contact-content-container">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show col-lg-8 offset-lg-2 col-12" style="margin-top:20px;" role="alert">
                    <strong>@lang('admin.Success!')</strong> {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h4 class="contact-us-header">@lang('front.Contact us')</h4>
            <form style="min-height: 756px; display: flex; flex-direction: column; justify-content: space-evenly" method="post">
                <input type="text" name="contact-title" class="contact-title" value="">
                @csrf
                @if(!Auth::check())
                    <div class="form-group">
                        <label for="first_name" style="font-family: Mulish-Light fantasy; font-size: 16px; margin-bottom: 10px">@lang('front.First Name')</label>
                        <input type="text" name="first_name" class="form-control">
                        @error('first_name') <span style="color:red">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name" style="font-family: Mulish-Light fantasy; font-size: 16px; margin-bottom: 10px">@lang('front.Last Name')</label>
                        <input type="text" name="last_name" class="form-control">
                        @error('last_name') <span style="color:red">{{$message}}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email" style="font-family: Mulish-Light fantasy; font-size: 16px; margin-bottom: 10px">@lang('front.Email')</label>
                        <input type="email" class="form-control" name="email">
                        @error('email') <span style="color:red">{{$message}}</span>@enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="message" style="font-family: Mulish-Light fantasy; font-size: 16px; margin-bottom: 10px">@lang('front.Message')</label>
                    <textarea style="min-height: 196px" type="text" name="message" class="form-control"></textarea>
                    @error('message') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <button type="submit" class="btn btn-dark" style="width: 220px; background-color: #1351b8; text-align: center; font-family: Mulish-ExtraLight, fantasy; font-size: 14px; color: white; font-weight:bolder ">@lang('front.SUBMIT')</button>
            </form>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

