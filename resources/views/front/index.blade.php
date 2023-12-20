@extends('layouts.front')
@section('meta_title', $category->name)
@section('meta_description', $category->name)

@section('title')
Variation System - {{$category->name}}
@endsection
@section('css')
@if($background->bg_type == 2)
<style>
    #content {
        background-image: url({{ asset('bg_images/' . $background->bg_image) }});
    }
</style>
@endif
@endsection
@section('content')
<section id="content" @if($background->bg_type == 1) style="background-color: {{ $background->bg_color }};" @endif>
    <footer>
        <div class="footer_mobile">  
            <li>
                <a target="_blank" href="https://yappybracelets.com/">
                    <img src="assets/images/front/new.png"  width="27px">
                </a>
            </li>
        </div>
    </footer>
</section>
@endsection