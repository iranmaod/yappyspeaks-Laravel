@extends('layouts.front')
@section('meta_title', $variation->name)
@section('meta_description', $variation->description)

@section('title')
Variation System - {{$category->name}}
@endsection
@section('css')
@if($background->bg_type == 2)
<style>
    #content {
        background-image: url({{ asset('bg_images/'.$background->bg_image) }});
    }
</style>
@endif
@endsection
@section('content')
<section id="content" @if($background->bg_type == 1) style="background-color: {{ $background->bg_color }};" @endif>
    <section>
        <div class="Main-Section">
            <p>{{$category->name}}</p>
            <h4>{{$variation->name}}</h4>
            <h1>{{$variation->description}}</h1>
        </div>
    </section>
    <footer>
        <div class="footer_mobile">  
            {{-- <li>
                <a href=""><img src="assets/images/front/heart.png" alt="heart-image" width="27px">
                </a>
                <p>171k</p>
            </li> --}}
            <li>
                <a onclick="shareLink()" href="javascript:;">
                    <img src="assets/images/front/upload.png" alt="heart-image" width="27px">
                </a> 
                <p>123k</p>
            </li>
            <li>
                <a target="_blank" href="https://yappybracelets.com/">
                    <img src="assets/images/front/more.png"  width="27px">
                </a>
            <p>More</p>
            </li>
        </div>
    </footer>
</section>
@endsection