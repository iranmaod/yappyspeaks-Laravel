@extends('layouts.admin')
@section('title', 'Manage Variations')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">All Variations @isset($category->name) of <label class="badge badge-pill badge-soft-success font-size-15" for=""> {{$category->name}} </label>@endisset </h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">All Variations</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="w-100">
    <a href="{{ route('category-data.create') }}" class="btn btn-primary">Add New</a>
    <a href="{{ route('variations.import') }}" class="btn btn-primary"><i class="fas fa-solid fa-file-import"></i> Import</a>
    <div class="d-flex  align-items-center justify-content-end">
        <label class="mb-0 me-3" for="">Filter by Category:</label>
        <select id="selectcategory" style="width: 20%" class="form-select" name="" id="">
            <option value="">Select Category</option>
            @foreach ($categories as $item)
            <option @isset($category->id) {{$category->id == $item->id ? 'selected' : ''}} @endisset value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
        <div class="card p-4 rounded cShadow table-responsive">
                <table id="datatable" class="table table-bordered  table-hover dt-responsive display nowrap">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>


    $('#datatable').DataTable({
        
        serverSide: true,
        processing: true,
        ajax: '@isset($category->id) @if ($category->id) {{route('category.variations',$category->id)}}  @else {{route('category.variations')}} @endif @endisset',
        columns: [
            {
                data: 'category',
                name: 'category',
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'actions',
                name: 'actions'
            },
        ]
    });
$(document).ready(function() {
    $('#selectcategory').change(function() {
    var selectedValue = $(this).val();
    console.log(selectedValue)
    // alert(selectedValue)
    if(selectedValue){
        window.location.href = '{{ url('/category/variations/') }}/' + selectedValue;
    }else{
        window.location.href = '{{ url('/category/variations/') }}'
    }
    
});
});

</script>
<script>
    $(document).ready(function() {
        $('#datatable').on('click', '.delete-btn', function(e) {
            e.preventDefault(); // Prevent the form submission
            const form = $(this).closest('form');
            const rowId = $(this).data('row-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the form submission to delete the record
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });
    });
</script>
@endsection