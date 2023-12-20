@extends('layouts.admin')
@isset($category)
@section('title', 'Edit Category')
@else
@section('title', 'Add Category')
@endisset
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            @isset($category)
            <h4 class="mb-sm-0 font-size-18">Edit Category</h4>
            @else
            <h4 class="mb-sm-0 font-size-18">Add New Category</h4>
            @endisset
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category</li>
                    @isset($category)
                    <li class="breadcrumb-item active">Edit Category</li>
                    @else
                    <li class="breadcrumb-item active">Add New Category</li>
                    @endisset
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="card p-4 rounded cShadow container-fluid">
    @isset($category)
    <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @else
        <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
            @endisset
            @csrf
            <div class="row">

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
                <div class="form-group col-sm-6 mb-2"></div>
                <div class="form-group col-sm-6 mb-2">
                    <label for="">Image</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="image" @isset($category)value="{{$category->image}}" @endisset placeholder="Select image" accept="image/*">
                    </div>
                    <label for="">Min: (390 X 844 px) Max: (700 X 1280 px)</label>
                    @error('image')
                    <span class="invalid-feedback mt-0" @error('image')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @isset($category->image)
                @if ($category->image)
                <div class="form-group col-sm-6">
                    <img class="rounded-circle header-profile-user" src="{{ asset('category_images/'.$category->image) }}" style="width:100px;height:100px;" alt="">
                </div> 
                @endif
                @endisset
                <div class="form-group col-sm-6 mb-2">
                    <label for="">Slug/URL<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" name="slug" @isset($category)value="{{$category->slug}}" @endisset placeholder="Enter Slug or URL">
                    </div>
                    <span>Example: my_category</span>
                    @error('slug')
                    <span class="invalid-feedback mt-0" @error('slug')style="display: block" @enderror role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
@endsection