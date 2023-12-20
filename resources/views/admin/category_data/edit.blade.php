@extends('layouts.admin')
@isset($category)
@section('title', 'Edit Variations')
@else
@section('title', 'Add Variations')
@endisset
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            @isset($category)
            <h4 class="mb-sm-0 font-size-18">Edit Variation of  <label id="selectedCat" class="badge badge-pill badge-soft-success font-size-15" for="">@isset($category_id) {{$category_id->name}} @endisset</label></h4>
            @else
            <h4 class="mb-sm-0 font-size-18">Add New Variation of  <label id="selectedCat" class="badge badge-pill badge-soft-success font-size-15" for="">@isset($category_id) {{$category_id->name}} @endisset</label></h4>
            @endisset
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category Variations</li>
                    @isset($category)
                    <li class="breadcrumb-item active">Edit Variations</li>
                    @else
                    <li class="breadcrumb-item active">Add New Variations</li>
                    @endisset
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="card p-4 rounded cShadow container-fluid">
    @isset($category)
    <form action="{{ route('category-data.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @else
        <form action="{{ route('category-data.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="">Name<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" name="name" @isset($category)value="{{$category->name}}" @endisset placeholder="Enter Name">
                    </div>
                    @error('name')
                    <span class="invalid-feedback mt-0" @error('name')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm-12 mb-2">
                    <label for="">Description<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <textarea  class="form-control" name="description" id="" cols="30" rows="10" placeholder="Enter description">@isset($category){{$category->description}}@endisset</textarea>
                    </div>
                    @error('description')
                    <span class="invalid-feedback mt-0" @error('description')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                {{-- <div class="form-group col-sm-6 mb-2">
                    <label for="">Image</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="image" @isset($category)value="{{$category->image}}" @endisset placeholder="Select image">
                    </div>
                    @error('image')
                    <span class="invalid-feedback mt-0" @error('image')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <img class="rounded-circle header-profile-user" src="{{ isset($category->image) ? asset('category_data/'.$category->image) : asset('/assets/images/users/avatar-9.png') }}" style="width:100px;height:100px;" alt="Header Avatar">
                </div>  --}}
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