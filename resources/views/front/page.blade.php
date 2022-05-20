@extends('front.layout')
@section('custom_css')
    <style>
        body{
            min-height: 100vh;
        }
        .page-container{
            background-image: url('{{asset('images/about_page_background.jpg')}}');
        }
        .about-content-container{
            background-color: rgba(255, 255, 255, 0.7);
            width: 750px;
            height:826px;
            padding:50px;
            overflow: auto;
        }
        .about-us-header{
            font-family: DroidSerif, sans-serif
        }
        @media(max-width: 767px){
            .page-container{
                padding:20px 5px;
                background-size: cover;
            }
            .about-content-container{

                width: auto;
                padding:10px 5px;
            }
            .about-us-header{
                font-size: 20px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-container" style="background-image: url('{{Storage::url('/pages/' . $page->background_image)}}')">
        <div class="offset-lg-2 about-content-container" style="">
            <h4 class="about-us-header">{{$page->title}}</h4>
            <div style="margin-top:20px">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection

