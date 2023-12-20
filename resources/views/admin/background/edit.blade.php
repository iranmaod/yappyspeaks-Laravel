@extends('layouts.admin')
@isset($category)
@section('title', 'Edit Background')
@else
@section('title', 'Add Background')
@endisset
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            @isset($category)
            <h4 class="mb-sm-0 font-size-18">Edit Background of  <label id="selectedCat" class="badge badge-pill badge-soft-success font-size-15" for="">@isset($category_id) {{$category_id->name}} @endisset</label></h4>
            @else
            <h4 class="mb-sm-0 font-size-18">Add New Background of  <label id="selectedCat" class="badge badge-pill badge-soft-success font-size-15" for="">@isset($category_id) {{$category_id->name}} @endisset</label></h4>
            @endisset
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category Backgrounds</li>
                    @isset($category)
                    <li class="breadcrumb-item active">Edit Background</li>
                    @else
                    <li class="breadcrumb-item active">Add New Background</li>
                    @endisset
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="card p-4 rounded cShadow container-fluid">
    @isset($category)
    <form action="{{ route('background.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @else
        <form action="{{ route('background.store') }}" method="post" enctype="multipart/form-data">
            @endisset
            @csrf
            <div class="row">
                <div class="form-group col-sm-6 mb-2">
                    <label for="">Select Category<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-select" required name="category_id" id="selectcategory">
                            <option value="">Select category</option>
                            @foreach ($categories as $item)
                                <option @isset($category_id) {{$category_id->id == $item->id ? 'selected' : ''}} @endisset @isset($category) {{$category->category_id == $item->id ? 'selected' : ''}} @endisset value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category')
                    <span class="invalid-feedback mt-0" @error('category')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm-6 mb-2">
                    <label for="">Background Type<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-select" required name="type_id" id="type_id">
                            <option value="">Select Type</option>
                            <option @isset($category) {{$category->bg_type == 1 ? 'selected' : ''}} @endisset value="1">Color</option>
                            <option @isset($category) {{$category->bg_type == 2 ? 'selected' : ''}} @endisset value="2">Image</option>
                        </select>
                    </div>
                </div>
                <div style="display: none" id="bg_color" class="form-group col-sm-6 mb-2">
                    <label for="">Background Color<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="color" class="form-control" name="bg_color" @isset($category)value="{{$category->bg_color}}" @endisset placeholder="Enter background color">
                    </div>
                    @error('bg_color')
                    <span class="invalid-feedback mt-0" @error('bg_color')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div style="display: none" id="bg_image" class="form-group col-sm-6 mb-2">
                    <label for="">Background Image<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="bg_image" @isset($category)value="{{$category->bg_image}}" @endisset placeholder="Select image" accept="image/*">
                    </div>
                    <label for="">Min: (390 X 844 px) Max: (700 X 1280 px)</label>
                    @error('bg_image')
                    <span class="invalid-feedback mt-0" @error('bg_image')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @isset($category->bg_image)
                    @if ($category->bg_image)
                        <div class="form-group col-sm-6">
                            <img class="rounded-circle header-profile-user" src="{{ asset('bg_images/'.$category->bg_image) }}" style="width:100px;height:100px;" alt="">
                        </div> 
                    @endif
                    
                    @endisset
                </div>
               
                <div class="form-group col-sm-6 mb-2 d-flex align-items-end">

                    <label for="switch4" data-on-label="Yes" data-off-label="No">
                        <label for="">Status: </label>
                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                            <input class="form-check-input" name="status" type="checkbox" id="SwitchCheckSizelg" @if(isset($category) && $category->status == 1) checked="" @endif>
                        </div>
                    </label>
                </div>
                <div class="form-group col-sm-12 mb-2">
                    <input type="submit" value="Submit" class="btn btn-primary btn-sm">
                </div>

            </div>
        </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    var type_id = $("#type_id option:selected").val();
    if(type_id == 1){
        $('#bg_color').show();
    }else if(type_id == 2){
        $('#bg_color').hide();
        $('#bg_image').show();
    }
    @error('bg_image')
    var msg = 2
    if(msg) {
        $('#bg_color').hide();
        $('#bg_image').show();
        $('#type_id option[value="2"]').attr("selected", "selected");
    }    
    @enderror
    
    $('#type_id').change(function() {
        var type_id = $(this).val();
        if(type_id == 1){
            $('#bg_color').show();
            $('#bg_image').hide();
        }else if(type_id == 2){
            $('#bg_color').hide();
            $('#bg_image').show();
        }
    });

    var selected = $("#selectcategory option:selected").text();
    var selectedValue = $("#selectcategory option:selected").val();
    if(selectedValue){
        $("#selectedCat").text(selected);
    }
    $('#selectcategory').change(function() {
        var selectedCat = $("#selectcategory option:selected").text();
        var selectedValue = $(this).val();
        if(selectedValue){
            $("#selectedCat").empty();
            $("#selectedCat").text(selectedCat);
        }else{
            $("#selectedCat").empty();
        }
    });
});
</script>
@endsection