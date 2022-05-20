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
        .about-us-text{
            font-size: 16pt;
            font-family: Mulish-ExtraLight, fantasy
        }
        .about-us-header{
            font-family: DroidSerif, sans-serif
        }
        .about-us-single-block{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center
        }
        .about-us-icon{
            width: 66px;
            height: 66px;
            border-radius: 30px;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22pt;
            color: orange;
        }
        .about-us-single-block-text{
            font-size: 14pt;
            font-family: Mulish-Light fantasy
        }
        .about-us-single-block-header{
            font-size: 20pt; font-family: DroidSerif, sans-serif
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
            .about-us-text{
                font-size: 13px;
            }
            .about-us-header{
                font-size: 20px;
            }
            .about-us-icon{
                width: 47px;
                height: 47px;
                font-size: 12pt;
            }
            .about-us-single-block-header{
                font-size: 17px;
            }
            .about-us-single-block-text{
                font-size: 13px;
            }

        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div class="offset-lg-2 about-content-container" style="">
            <h4 class="about-us-header">@lang('front.About us')</h4>
            <p class="about-us-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</p>
            <div class="about-us-single-block">
                <div class="about-us-icon"><i class="fas fa-user"></i></div>
                <div style="width: 75%">
                    <div class="about-us-single-block-header">Bio</div>
                    <div class="about-us-single-block-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</div>
                </div>
            </div>
        </div>
@endsection
@section('custom_scripts')
@endsection

