@extends('layouts.admin')
@section('title', 'Import Variations')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Import Variations of  <label id="selectedCat" class="badge badge-pill badge-soft-success font-size-15" for=""></label></h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Import Variations</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="card p-4 rounded cShadow container-fluid">
  <div class="row">
    <div class="col-md-2">
        <a class="btn btn-primary mb-3" href="{{asset('/import_sample/sample.csv')}}">Download Sample File</a>
    </div>
    
    <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
        @csrf
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
        </div>
        <div style="display: none" id="import_input" class="form-group col-sm-6 mb-2">
            <label for="">CSV or Excel File<span class="text-danger">*</span></label>
            <div class="input-group">
               <input required type="file" name="file" accept=".csv, .xls, .xlsx" class="form-control">
            </div>
            <label class="text-danger" for="">Select CSV or Excel File only</label>
            @error('file')
            <span class="invalid-feedback mt-0" @error('file')style="display: block" @enderror role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="form-group col-sm-12 mb-2 mt-3">
                <input type="submit" value="Import" class="btn btn-primary btn-sm">
            </div>
        </div>
        
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
$(document).ready(function() {
    // $('#import_input').hide();
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
            $('#import_input').show();
        }else{
            $("#selectedCat").empty();
            $('#import_input').hide();
        }
    });
    @error('file')
    var msg = 1
    if(msg) {
        // $("#selectedCat").empty();
        // $("#selectedCat").text(selectedCat);
        $('#import_input').show();
    }    
    @enderror
});
</script>
@endsection